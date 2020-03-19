<?php

namespace App\Jobs;

use App\Http\Controllers\ExternalRPIController;
use App\Models\Contact;
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
    private $message;

    private $file_content;
    private $file_name;
    private $file_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ExternalRPIController $rpiController, Contact $Contact, string $message, string $file_content = null, string $file_name = null, string $file_type = null)
    {
        $this->rpiController = $rpiController;

        $this->Contact = $Contact;
        $this->message = $message;
        $this->file_content = $file_content;
        $this->file_name = $file_name;
        $this->file_type = $file_type;

        $this->connection = 'database';

        $this->queue = 'whatsapp';

        $this->delay = 5;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->file_content) { // Send normal message
            Log::debug('\n\r SendingTextMessage to Contact contact_Jid from Job: ', [$this->Contact->whatsapp_id]);
            $this->rpiController->sendTextMessage($this->message, $this->Contact);
        }
        else {
            Log::debug('\n\r SendingFileMessage to Contact contact_Jid from Job: ', [$this->Contact->whatsapp_id]);
            $this->rpiController->sendFileMessage($this->file_content, $this->file_name, $this->file_type, $this->message, $this->Contact);
        }

    }
}
