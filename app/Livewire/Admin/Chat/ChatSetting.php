<?php

namespace App\Livewire\Admin\Chat;

use Livewire\Component;
use App\Models\Setting;

class ChatSetting extends Component
{
    public $autoGreetingEnabled = true;
    public $autoGreetingText;
    public $autoAckMessage;
    public $quickReplies = [];
    public $newReplyLabel = '';
    public $newReplyText = '';
    public $customerOptions = [];
    public $newCustomerOption = '';

    public function mount()
    {
        $this->autoGreetingEnabled = Setting::getValue('chat_auto_greeting_enabled', '1') === '1';
        $this->autoGreetingText = Setting::getValue('chat_auto_greeting', 'Halo, ada yang bisa kami bantu?');
        $this->autoAckMessage = Setting::getValue('chat_auto_ack_message',
            'Terima kasih, pesan Anda sudah kami terima. Mohon tunggu sebentar, admin kami akan segera membantu Anda.');

        $saved = Setting::getValue('chat_quick_replies', '[]');
        $this->quickReplies = json_decode($saved, true) ?: [];

        $savedOptions = Setting::getValue('chat_customer_options', '[]');
        $this->customerOptions = json_decode($savedOptions, true) ?: [];
    }

    public function saveAutoGreeting()
    {
        Setting::setValue('chat_auto_greeting_enabled', $this->autoGreetingEnabled ? '1' : '0');
        Setting::setValue('chat_auto_greeting', $this->autoGreetingText);
        Setting::setValue('chat_auto_ack_message', $this->autoAckMessage);
        session()->flash('success', 'Pengaturan sapaan otomatis berhasil disimpan!');
    }

    public function addQuickReply()
    {
        $this->validate([
            'newReplyLabel' => 'required|max:50',
            'newReplyText' => 'required|max:500',
        ]);

        $this->quickReplies[] = [
            'label' => $this->newReplyLabel,
            'text' => $this->newReplyText,
        ];

        $this->saveQuickReplies();
        $this->reset(['newReplyLabel', 'newReplyText']);
        session()->flash('success', 'Balasan cepat berhasil ditambahkan!');
    }

    public function deleteQuickReply($index)
    {
        if (isset($this->quickReplies[$index])) {
            array_splice($this->quickReplies, $index, 1);
            $this->saveQuickReplies();
            session()->flash('success', 'Balasan cepat berhasil dihapus!');
        }
    }

    private function saveQuickReplies()
    {
        Setting::setValue('chat_quick_replies', json_encode($this->quickReplies));
    }

    public function addCustomerOption()
    {
        $this->validate([
            'newCustomerOption' => 'required|max:200',
        ]);

        $this->customerOptions[] = $this->newCustomerOption;
        Setting::setValue('chat_customer_options', json_encode($this->customerOptions));
        $this->reset('newCustomerOption');
        session()->flash('success', 'Opsi pelanggan berhasil ditambahkan!');
    }

    public function deleteCustomerOption($index)
    {
        if (isset($this->customerOptions[$index])) {
            array_splice($this->customerOptions, $index, 1);
            Setting::setValue('chat_customer_options', json_encode($this->customerOptions));
            session()->flash('success', 'Opsi pelanggan berhasil dihapus!');
        }
    }

    public function render()
    {
        return view('livewire.admin.chat.chat-setting')
            ->layout('components.layouts.app')
            ->layoutData(['title' => 'Pengaturan Chat']);
    }
}
