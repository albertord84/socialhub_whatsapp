<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewContactMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $channel;

    public $socket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $company_id, ?int $new_contacts_count)
    {
        $this->message = $new_contacts_count;
        $this->channel = "sh.contact-to-bag.$company_id";

        // $this->event = "NewContactMessage";

        // $this->socket = "sh.contact-to-bag.$company_id";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel($this->channel);
        Log::debug('NewContactMessage broadcastOn', [$this]);
        return [$this->channel];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        Log::debug('NewContactMessage broadcastAs', [$this]);
        return 'NewContactMessage';
    }
}
