<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Company;
use App\SystemConfig;

class EmailSiginCompany extends Mailable
{
    use Queueable, SerializesModels;

    public $Seller;
    public $userManager;
    public $Company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $Seller, User $userManager, Company $Company)
    {
        $this->Seller=$Seller;
        $this->userManager=$userManager;
        $this->Company=$Company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.SiginCompany');

        return $this
            ->from('system@socialhub.pro') //pegar desde a tabela system_config
            ->view('view.emails.SiginCompany')
            ->with([
                'Seller' => $this->Seller,
            ]);
    }
}
