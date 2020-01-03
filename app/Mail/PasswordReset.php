<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.password_reset')
            ->to($this->data['email'])
            ->subject("Redefinir senha");

            // return $this
            // ->from('system@socialhub.pro') //pegar desde o .env  env("MAIL_USERNAME")
            // ->view('mails.password_reset', ['data' => $this->data])
            // ->subject("Redefinir senha");;
    }
}
