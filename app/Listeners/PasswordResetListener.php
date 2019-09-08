<?php

namespace App\Listeners;

use App\Events\PasswordResetEvent;
use App\Mail\PasswordReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class PasswordResetListener
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
    public function handle(PasswordResetEvent $event)
    {
        $this->mail->to($event->data['email'])
            ->send(new PasswordReset($event->data));
    }
}
