<?php

namespace App\Listeners;

use App\Events\RegisterUserEvent;
use App\Mail\RegisterUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class RegisterUserListener
{
    /**
     * @var Mailer
     */
    private $mail;

    /**
     * Create the event listener.
     *
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RegisterUserEvent $event)
    {
        $this->mail->to($event->data['email'])
            ->send(new RegisterUser($event->data));
    }
}
