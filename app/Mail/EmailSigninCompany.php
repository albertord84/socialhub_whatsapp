<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Models\Company;
use App\ModeSystemConfig;

class EmailSigninCompany extends Mailable
{
    use Queueable, SerializesModels;

    public $Seller;
    public $User;
    public $Company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $Seller, User $User, Company $Company)
    {
        $this->Seller=$Seller;
        $this->User=$User;
        $this->Company=$Company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('system@socialhub.pro', 'SocialHub') //pegar desde o .env  env("MAIL_USERNAME")
            ->subject('Cadastro de empresa em SocialHub')
            ->view('mails.SigninCompany', ['Seller' => $this->Seller,'User' => $this->User, 'Company' => $this->Company]);
    }
}
