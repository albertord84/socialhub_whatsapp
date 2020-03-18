<?php

namespace App\Jobs;

use App\Http\Controllers\ExternalRPIController;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWhatsAppMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $retryAfter = 10;

    // public $delay = 10;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->file_content) { // Send normal message
            $this->rpiController->sendTextMessage($this->message, $this->Contact);
        }
        else {
            $this->rpiController->sendFileMessage($this->file_content, $this->file_name, $this->file_type, $this->message, $this->Contact);
        }

    }
}
