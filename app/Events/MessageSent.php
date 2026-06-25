<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message_id;
    public $conversation_id;
    public $body;
    public $image;
    public $is_admin;
    public $sender_name;
    public $time_formatted;
    public $created_at;

    public function __construct($message)
    {
        $this->message_id = $message->id;
        $this->conversation_id = $message->conversation_id;
        $this->body = $message->body;
        $this->image = $message->image ? asset($message->image) : null;
        $this->is_admin = $message->is_admin;
        $this->time_formatted = $message->created_at->format('H:i');
        $this->created_at = $message->created_at->toIso8601String();

        if ($message->is_admin) {
            $this->sender_name = 'Admin';
        } elseif ($message->conversation && $message->conversation->user) {
            $this->sender_name = $message->conversation->user->name ?? 'Pelanggan';
        } else {
            $this->sender_name = 'Pelanggan';
        }
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->conversation_id);
    }

    public function broadcastAs()
    {
        return 'message-sent';
    }
}
