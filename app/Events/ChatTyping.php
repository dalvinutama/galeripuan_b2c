<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatTyping implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $conversation_id;
    public $is_admin;
    public $is_typing;
    public $sender_name;

    public function __construct($conversationId, $isAdmin, $isTyping, $senderName = '')
    {
        $this->conversation_id = $conversationId;
        $this->is_admin = $isAdmin;
        $this->is_typing = $isTyping;
        $this->sender_name = $senderName;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->conversation_id);
    }

    public function broadcastAs()
    {
        return 'chat-typing';
    }
}
