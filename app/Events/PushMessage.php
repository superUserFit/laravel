<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $User, $Message;

    /**
     * Create a new event instance.
     */
    public function __construct($User, $Message)
    {
        $this->User = $User;
        $this->Message = $Message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('send-message'),
        ];
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
