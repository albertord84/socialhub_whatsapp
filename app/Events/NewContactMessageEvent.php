<?php

namespace App\Events;

class NewContactMessageEvent extends PusherEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $company_id, ?int $new_contacts_count)
    {
        $this->message = $new_contacts_count;
        $this->channel = "sh.contact-to-bag.$company_id";

        parent::__construct($new_contacts_count, "sh.contact-to-bag.$company_id");
    }

}
