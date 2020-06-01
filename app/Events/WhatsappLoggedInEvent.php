<?php

namespace App\Events;

class WhatsappLoggedInEvent extends PusherEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $manager_id)
    {
        parent::__construct("NewWhatsappLogged", "sh.whatsapp-logged.$manager_id");
    }

}
