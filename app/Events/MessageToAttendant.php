<?php

namespace App\Events;

use App\Models\ExtendedChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageToAttendant implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ExtendedChat $Chat)
    {
        $this->message = $Chat->toJson();
        $this->channel = "sh.message-to-attendant.$Chat->attendant_id";
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
