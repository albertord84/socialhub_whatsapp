<?php

namespace App\Events;

class MyEvent extends PusherEvent
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 'my-channel', 'my-event');
    }

}