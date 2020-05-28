<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class EmailSigninAttendant extends Mailable
{
    use Queueable, SerializesModels;

    public $Manager;
    public $User;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $Manager, User $User)
    {
        $this->Manager=$Manager;
        $this->User=$User;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');

        return $this
            ->from('system@socialhub.pro', 'SocialHub') //pegar desde o .env  env("MAIL_USERNAME")
            ->subject('Cadastro de usuário em SocialHub')
            ->view('mails.SigninAttendant', ['Manager' => $this->Manager,'User' => $this->User]);
    }
}
