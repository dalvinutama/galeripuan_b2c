<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Events\MessageSent;
use App\Events\ChatTyping;

class ChatWidget extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $body = '';
    public $uuid;
    public $isExpanded = false;
    public $imagePreview = null;
    public $image;
    public $zoomedImage = null;
    public $conversationId = null;

    protected $lastTypingBroadcast = 0;

    public function mount()
    {
        if (!request()->cookie('chat_uuid')) {
            $this->uuid = (string) Str::uuid();
            Cookie::queue('chat_uuid', $this->uuid, 60 * 24 * 30);
        } else {
            $this->uuid = request()->cookie('chat_uuid');
        }
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendMessage()
    {
        $this->validate([
            'body' => 'required_without:image',
            'image' => 'nullable|image|max:5120'
        ]);

        $data = [
            'body' => $this->body ?? '',
            'is_admin' => false,
            'sender_id' => Auth::check() ? Auth::id() : null,
        ];

        if ($this->image) {
            $path = $this->image->store('chat-images', 'public');
            $data['image'] = 'storage/' . $path;
        } elseif ($this->imagePreview) {
            $data['image'] = $this->imagePreview;
        }

        if (Auth::check()) {
            $conversation = Conversation::firstOrCreate(
                ['user_id' => Auth::id()],
                ['uuid' => (string) Str::uuid()]
            );
        } else {
            $conversation = Conversation::firstOrCreate(
                ['uuid' => $this->uuid],
                ['user_id' => null]
            );
        }

        $message = $conversation->messages()->create($data);

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
        }

        $hasAdminReply = $conversation->messages()->where('is_admin', true)->exists();
        if (\App\Models\Setting::getValue('chat_auto_greeting_enabled', '1') === '1' && !$hasAdminReply) {
            $greeting = \App\Models\Setting::getValue('chat_auto_greeting', 'Halo, ada yang bisa kami bantu?');
            $autoReply = $conversation->messages()->create([
                'body' => $greeting,
                'is_admin' => true,
                'sender_id' => null,
            ]);
            try {
                broadcast(new MessageSent($autoReply))->toOthers();
            } catch (\Exception $e) {
            }

            $options = json_decode(\App\Models\Setting::getValue('chat_customer_options', '[]'), true) ?: [];
            if (!empty($options) && !$conversation->messages()->where('type', 'suggested_options')->exists()) {
                $conversation->messages()->create([
                    'body' => json_encode($options),
                    'is_admin' => true,
                    'sender_id' => null,
                    'type' => 'suggested_options',
                ]);
            }
        }

        $this->reset(['body', 'image', 'imagePreview']);
    }

    public function updatedBody()
    {
        if (!$this->conversationId) return;

        $now = time();
        if ($now - $this->lastTypingBroadcast < 2) return;
        $this->lastTypingBroadcast = $now;

        $senderName = Auth::check() ? (Auth::user()->name ?? 'Pelanggan') : 'Pelanggan';
        try {
            broadcast(new ChatTyping(
                $this->conversationId,
                false,
                !empty(trim($this->body ?? '')),
                $senderName
            ))->toOthers();
        } catch (\Exception $e) {
        }
    }

    public function sendSuggestedReply($text)
    {
        $this->body = $text;
        $this->sendMessage();

        if ($this->conversationId) {
            $conv = \App\Models\Conversation::find($this->conversationId);
            if ($conv) {
                $ackMsg = \App\Models\Setting::getValue('chat_auto_ack_message',
                    'Terima kasih, pesan Anda sudah kami terima. Mohon tunggu sebentar, admin kami akan segera membantu Anda.');
                $autoAck = $conv->messages()->create([
                    'body' => $ackMsg,
                    'is_admin' => true,
                    'sender_id' => null,
                ]);
                try {
                    broadcast(new MessageSent($autoAck))->toOthers();
                } catch (\Exception $e) {
                }
            }
        }
    }

    #[On('messageReceived')]
    public function refreshMessages()
    {
    }

    public function toggleSize()
    {
        $this->isExpanded = !$this->isExpanded;
    }

    #[On('buka-chat')]
    public function isiPesanOtomatis($pesan = '', $gambar = null)
    {
        $this->isOpen = true;
        $this->body = $pesan;
        $this->imagePreview = $gambar;
    }

    public function render()
    {
        if (Auth::check()) {
            $conversation = Conversation::with('messages')
                                        ->where('user_id', Auth::id())
                                        ->first();
        } else {
            $conversation = Conversation::with('messages')
                                        ->where('uuid', $this->uuid)
                                        ->whereNull('user_id')
                                        ->first();
        }

        $messages = $conversation ? $conversation->messages : collect();
        $this->conversationId = $conversation ? $conversation->id : null;

        $suggestedOptions = json_decode(\App\Models\Setting::getValue('chat_customer_options', '[]'), true) ?: [];

        $adminLastActivity = \App\Models\Admin::latest('last_activity')->value('last_activity');
        $adminLastActivity = $adminLastActivity ? \Carbon\Carbon::parse($adminLastActivity)->timestamp : null;

        return view('livewire.front.chat-widget', [
            'messages' => $messages,
            'suggestedOptions' => $suggestedOptions,
            'adminLastActivity' => $adminLastActivity,
        ]);
    }
}
