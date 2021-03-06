<?php

namespace App\Jobs;

use App\Events\MessageToAttendantEvent;
use App\Http\Controllers\ExternalRPIController;
use App\Http\Controllers\MessagesStatusController;
use App\Models\Contact;
use App\Models\ExtendedChat;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    
    /**
     * O --timeout valor sempre deve ser pelo menos alguns segundos menor que o retry_aftervalor da configuração. 
     *Isso garantirá que um trabalhador que processa um determinado trabalho seja sempre morto antes que o trabalho seja tentado novamente. 
     *Se sua --timeout opção for maior que o retry_after valor de configuração, seus trabalhos poderão ser processados ​​duas vezes.     
     */
    // public $timeout = 25;

    // Time worker will wait to retry again each work
    public $retryAfter = 3;
    
    // Time worker will be sleeping wheter not work
    // public $sleep = 3;

    public $deleteWhenMissingModels = true;

    
    private $rpiController;

    private $Contact;
    private $Chat;
    private $chat_input;

    private $file_name;
    private $file_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct(ExternalRPIController $rpiController, Contact $Contact, array $chat_input)
    public function __construct(ExternalRPIController $rpiController, Contact $Contact, array $chat_input, string $queue = null, string $file_name = null, string $file_type = null)
    {
        $this->rpiController = $rpiController;

        $this->Contact = $Contact;
        $this->chat_input = $chat_input;
        // $this->Chat = new ExtendedChat;
        $this->file_name = $file_name;
        $this->file_type = $file_type;

        $this->connection = 'redis';

        $this->queue = $queue;

        // Time to wait before allow process Job
        // $this->delay = 1;

        $this->tries = 3;
        $this->retryAfter = 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug('SendWhatsAppMsg Handle...: ', [$this->chat_input]);
        $return = 0;

        $ExtendedChat = new ExtendedChat();
        $ExtendedChat->table = $this->chat_input['attendant_id'];
        $ExtendedChat = $ExtendedChat->find($this->chat_input['chat_id']);

        // Tell the user we're retrying for the nth time
        if ($this->attempts() > 1) {
            Log::debug('SendWhatsAppMsg Handle attempts...: ', [$this->attempts()]);
            // broadcast(new MessageToAttendantEvent($ExtendedChat));
        }

        if (!$this->file_name) { // Send normal message
            $response = $this->rpiController->sendTextMessage($ExtendedChat->message, $this->Contact);
            // Log::debug('\n\r SendingTextMessage to Contact contact_Jid from Job handled: ', [$this->Contact->whatsapp_id]);
        }
        else {
            $response = $this->rpiController->sendFileMessage($this->file_name, $this->file_type, $ExtendedChat->message, $this->Contact);
            // Log::debug('\n\r SendingFileMessage to Contact contact_Jid from Job handled: ', [$this->Contact->whatsapp_id]);
        }

        
        $responseJson = json_decode($response);
        if (isset($responseJson->status) && ($responseJson->status)) {
        // if (isset($responseJson->MsgID) && ($responseJson->MsgID)) {
            $ExtendedChat->status_id = MessagesStatusController::SENDED;
        } else {
            Log::debug('\n\r SendingMessage Failed', [$responseJson]);
            $ExtendedChat->status_id = MessagesStatusController::FAIL;

            if ($this->tries--) {
                Log::debug('\n\r SendingMessage Failed Tries number:', [3 - $this->tries, $ExtendedChat->message]);

                sleep(5);
                $this->handle();

                return -1;
            } else {
                Log::debug('\n\r SendingMessage Failed after 4 times!', [$responseJson, $ExtendedChat->message]);
            }
            // throw new Exception("Erro enviando mensagem, verifique conectividade!", 1);
        }
        
        $ExtendedChat->save();

        $ExtendedChat->Contact = $this->Contact;
        
        if ($ExtendedChat->attendant_id) {
            broadcast(new MessageToAttendantEvent($ExtendedChat));
        }

    }
}
