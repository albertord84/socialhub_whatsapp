<?php

namespace App\Jobs;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ExternalRPIController;
use App\Http\Controllers\MessagesStatusController;
use App\Models\Api;
use App\Models\Contact;
use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMsgApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    const QUEUE_NAME = 'api_messages';
    
    
    /**
     * O --timeoutvalor sempre deve ser pelo menos alguns segundos menor que o retry_aftervalor da configuração. 
     *Isso garantirá que um trabalhador que processa um determinado trabalho seja sempre morto antes que o trabalho seja tentado novamente. 
     *Se sua --timeoutopção for maior que o retry_aftervalor de configuração, seus trabalhos poderão ser processados ​​duas vezes.     
     */
    public $timeout = 25;
    // Time worker will wait to retry again each work
    public $retryAfter = 30;
    
    // Time worker will be sleeping wheter not work
    public $sleep = 3;

    public $deleteWhenMissingModels = true;

    
    private $rpiController;

    private $Contact;

    private $ApiMessage;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ExternalRPIController $rpiController, Contact $Contact, $ApiMessage, string $queue = SendWhatsAppMsgApi::QUEUE_NAME)
    // public function __construct(ExternalRPIController $rpiController, Contact $Contact, Api $ApiMessage, string $queue = null)
    {
        $this->rpiController = $rpiController;

        $this->Contact = $Contact;
        $this->ApiMessage = $ApiMessage;

        $this->connection = 'redis';

        $this->queue = $queue;

        // Time to wait before allow process Job
        $this->delay = 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Handle SendWhatsAppMsgApi...: ', [$this->Contact, $this->ApiMessage]);

        if (!$this->ApiMessage['file_name']) {
            $response = $this->rpiController->sendTextMessage($this->ApiMessage['message'], $this->Contact);
        } else {
            $response = $this->rpiController->sendFileMessage($this->ApiMessage['file_name'], $this->ApiMessage['file_type'], $this->ApiMessage['message'], $this->Contact);
        }
        // $response=null;
        Log::debug('\n\r SendingTextMessage to Contact contact_Jid from Job SendWhatsAppMsgBling handled: ', [$this->Contact->whatsapp_id]);

        $Api = new Api();
        $Api->table = $this->Contact->company_id;
        $this->ApiMessage = $Api->find($this->ApiMessage['id']);
        $responseJson = json_decode($response);
        if (isset($responseJson->MsgID)) {
            Log::debug('\n\r SendedTextMessage to Contact contact_Jid from Job SendWhatsAppMsgBling handled: ', [$this->Contact->whatsapp_id, $this->ApiMessage]);
            $this->ApiMessage->status_id = ApiController::SENDED;
        } else {
            $this->ApiMessage->status_id = ApiController::PROBLEM;
            // throw new Exception("Erro enviando mensagem, verifique conectividade!", 1);
        }
        
        $this->ApiMessage->save();

        // if ($this->ApiMessage->attendant_id) {
            // broadcast(new MessageToAttendantEvent($this->ApiMessage));
        // }   
    }
}
