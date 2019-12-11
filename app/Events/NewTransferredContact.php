<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewTransferredContact
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $channel;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $attendant_id, $contact)
    {
        $this->message = $contact->toJson();
        $this->channel = "sh.transferred-contact.$attendant_id";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->channel);
    }
}
