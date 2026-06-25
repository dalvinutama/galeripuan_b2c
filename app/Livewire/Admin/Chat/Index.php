<?php

namespace App\Livewire\Admin\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Setting;
use Livewire\WithFileUploads;
use App\Events\MessageSent;
use App\Events\ChatTyping;
use App\Events\MessagesRead;

class Index extends Component
{
    use WithFileUploads;

    public $conversations = [];
    public $selectedConversationId = null;
    public $messages = [];
    public $replyBody = '';
    public $editingMessageId = null;
    public $image;
    public $zoomedImage = null;
    public $showQuickReplies = false;
    public $quickReplies = [];

    protected $lastTypingBroadcast = 0;

    public function loadQuickReplies()
    {
        $saved = Setting::getValue('chat_quick_replies', '[]');
        $this->quickReplies = json_decode($saved, true) ?: [];
    }

    public function selectConversation($id)
    {
        $this->selectedConversationId = $id;
        $this->editingMessageId = null;
        $this->reset(['replyBody', 'image']);
        $this->loadQuickReplies();

        $conv = Conversation::find($id);
        if ($conv) {
            $hasUnread = $conv->messages()->where('is_admin', false)->where('is_read', false)->exists();
            $conv->messages()->where('is_admin', false)->where('is_read', false)->update(['is_read' => true, 'is_delivered' => true]);
            if ($hasUnread) {
                try {
                    broadcast(new MessagesRead($id))->toOthers();
                } catch (\Exception $e) {
                }
            }
            $this->loadMessages();
            $this->dispatch('scroll-ke-bawah');
        }
    }

    public function loadMessages()
    {
        if ($this->selectedConversationId) {
            $conv = Conversation::find($this->selectedConversationId);
            if ($conv) {
                $this->messages = $conv->messages()->get()->toArray();
            }
        }
    }

    public function sendReply()
    {
        $this->validate([
            'replyBody' => 'required_without:image',
            'image' => 'nullable|image|max:5120'
        ]);

        if ($this->editingMessageId) {
            $msg = Message::find($this->editingMessageId);
            if ($msg && $msg->is_admin) {
                $msg->update(['body' => $this->replyBody ?? '']);
            }
            $this->editingMessageId = null;
        } else {
            if ($this->selectedConversationId) {
                $conv = Conversation::find($this->selectedConversationId);
                if ($conv) {
                    $data = [
                        'body' => $this->replyBody ?? '',
                        'is_admin' => true,
                        'sender_id' => null,
                    ];

                    if ($this->image) {
                        $path = $this->image->store('chat-images', 'public');
                        $data['image'] = 'storage/' . $path;
                    }

                    $message = $conv->messages()->create($data);

                    try {
                        broadcast(new MessageSent($message))->toOthers();
                    } catch (\Exception $e) {
                    }
                }
            }
        }

        $this->reset(['replyBody', 'image']);
        $this->loadMessages();
        $this->dispatch('scroll-ke-bawah');
    }

    public function toggleQuickReplies()
    {
        $this->showQuickReplies = !$this->showQuickReplies;
        if ($this->showQuickReplies) {
            $this->loadQuickReplies();
        }
    }

    public function sendQuickReply($text)
    {
        $this->replyBody = $text;
        $this->showQuickReplies = false;
        $this->sendReply();
    }

    public function updatedReplyBody()
    {
        if (!$this->selectedConversationId) return;

        $now = time();
        if ($now - $this->lastTypingBroadcast < 2) return;
        $this->lastTypingBroadcast = $now;

        try {
            broadcast(new ChatTyping(
                $this->selectedConversationId,
                true,
                !empty(trim($this->replyBody ?? '')),
                auth()->guard('admin')->user()->name ?? 'Admin'
            ))->toOthers();
        } catch (\Exception $e) {
        }
    }

    #[On('messageReceived')]
    public function onMessageReceived()
    {
        if ($this->selectedConversationId) {
            $conv = Conversation::with('messages')->find($this->selectedConversationId);
            if ($conv) {
                $unread = $conv->messages()->where('is_admin', false)->where('is_read', false);
                if ($unread->exists()) {
                    $unread->update(['is_read' => true, 'is_delivered' => true]);
                    try {
                        broadcast(new MessagesRead($this->selectedConversationId))->toOthers();
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        $this->loadMessages();
    }

    #[On('refreshSidebar')]
    public function refreshSidebar()
    {
    }

    public function deleteConversation($id)
    {
        $conversation = Conversation::find($id);
        if ($conversation) {
            $conversation->messages()->delete();
            $conversation->delete();

            if ($this->selectedConversationId == $id) {
                $this->selectedConversationId = null;
                $this->messages = [];
                $this->reset(['replyBody', 'image', 'editingMessageId']);
            }
        }
    }

    public function deleteMessage($id)
    {
        $msg = Message::find($id);
        if ($msg) {
            $msg->delete();
            $this->loadMessages();
        }
    }

    public function editMessage($id)
    {
        $msg = Message::find($id);
        if ($msg && $msg->is_admin) {
            $this->editingMessageId = $msg->id;
            $this->replyBody = $msg->body;
            $this->image = null;
        }
    }

    public function render()
    {
        Message::where('is_admin', false)->where('is_delivered', false)->update(['is_delivered' => true]);
        $this->conversations = Conversation::with(['messages', 'user'])->latest('updated_at')->get();
        return view('livewire.admin.chat.index')->layout('components.layouts.app');
    }
}
