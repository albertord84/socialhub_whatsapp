<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Pusher\Pusher;

class PusherEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $channel;

    public $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $message, ?string $chanel, string $event = PusherEvent::class)
    {
        $this->message = $message;
        $this->channel = $chanel;
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER','us2'),
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY', '0453e49e6ff2a71bcac2'),
            env('PUSHER_APP_SECRET', 'b7e14808af9318b972a1'),
            env('PUSHER_APP_ID', '1007997'),
            $options
        );

        $pusher->trigger($this->channel, $this->event, $this->message);

        return new Channel($this->channel);
    }

    public function broadcastAs()
    {
        return $this->event;
    }
}
