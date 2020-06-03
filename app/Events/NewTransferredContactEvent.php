<?php

namespace App\Events;

class NewTransferredContactEvent extends PusherEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $attendant_id,  $contact,  $oldAttendant)
    {
        parent::__construct(
            json_encode(array(
                'oldAttendant' => $oldAttendant->toJson(), 
                'contact' => $contact->toJson()
            )),
            "sh.transferred-contact.$attendant_id", 
            'NewTransferredContactEvent'
        );
    }

}
