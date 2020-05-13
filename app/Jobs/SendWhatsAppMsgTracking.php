<?php

namespace App\Jobs;

use App\Business\TrackingBusiness;
use App\Http\Controllers\ExternalRPIController;
use App\Http\Controllers\MessagesStatusController;
use App\Http\Controllers\StatusController;
use App\Models\Tracking;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use stdClass;

class SendWhatsAppMsgTracking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
        
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

    private $Tracking;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ExternalRPIController $rpiController, Contact $Contact, $Tracking, string $queue = null)
    // public function __construct(ExternalRPIController $rpiController, Contact $Contact, Tracking $Tracking, string $queue = null)
    {
        $this->rpiController = $rpiController;

        $this->Contact = $Contact;
        $this->Tracking = $Tracking;

        $this->connection = 'redis';
        // $this->connection = 'redis';

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
        Log::debug('Handle SendWhatsAppMsgTracking: ',);
        
        $TrackingBusiness = new TrackingBusiness();
        
        $Tracking = new Tracking(); $company_id = $this->Contact->company_id;    $Tracking->table = "$company_id";
        
        $this->Tracking = $Tracking->find($this->Tracking->id);
        $message_list = json_decode($this->Tracking->message_list) ?? array();
        
        Log::debug('Handle SendWhatsAppMsgTracking to: ', [$this->Tracking, $this->Contact]);
        
        $newMessage = $TrackingBusiness->getNewTrackingMessage($this->Tracking, $this->Contact->company_id);
        // dd($newMessage);

        if ($newMessage) {
            // if ($this->Contact->id == 1) $response = $this->rpiController->sendTextMessage($newMessage, $this->Contact);
            // $responseJson = json_decode($response);
            // Log::debug('\n\r SendingTextMessage to Contact contact_Jid from Job SendWhatsAppMsgTracking handled: ', [$this->Contact->whatsapp_id]);
            

            // if (isset($responseJson->MsgID) && $responseJson->MsgID != "") {
                $this->Tracking->sended += 1;
                // Add new Message to Object message list
                $message_list[count($message_list)] = $newMessage;
                $this->Tracking->message_list = json_encode($message_list);
            // } else {
                // throw new Exception("Erro enviando mensagem, verifique conectividade!", 1);
            // }
            
        }

        $this->Tracking->updated_at = Carbon::now();
        $this->Tracking->save();
    }
}