<?php

namespace App\Events;

class NewTransferredContactEvent extends PusherEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $attendant_id,  $contact)
    {
        parent::__construct($contact->toJson(), "sh.transferred-contact.$attendant_id");
    }

}
