<?php

namespace App\Events;

use App\Models\ExtendedChat;
use Illuminate\Support\Facades\Log;

class MessageToAttendantEvent extends PusherEvent
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ExtendedChat $Chat)
    {
        Log::debug('MessageToAttendantEvent ExtendedChat $Chat: ', [$Chat]);
        
        Log::debug('MessageToAttendantEvent $this->message: ', [$this->message]);

        parent::__construct(
            $Chat->toJson(), 
            "sh.message-to-attendant.$Chat->attendant_id", 
            "MessageToAttendantEvent"
        );
    }

}
