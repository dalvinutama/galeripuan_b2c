<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MessagesRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $conversationId;

    public function __construct($conversationId)
    {
        $this->conversationId = $conversationId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->conversationId);
    }

    public function broadcastAs()
    {
        return 'messages-read';
    }
}
