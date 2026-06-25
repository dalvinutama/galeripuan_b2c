<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class NotificationDropdown extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $totalUnread = 0;

    protected $listeners = ['notif-updated' => 'refreshNotifs'];

    public function mount()
    {
        $this->refreshNotifs();
    }

    public function refreshNotifs()
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin) {
            $this->unreadCount = 0;
            $this->totalUnread = 0;
            $this->notifications = [];
            return;
        }

        $this->totalUnread = $admin->unreadNotifications->count();
        $this->unreadCount = min($this->totalUnread, 99);
        // Mengambil notifikasi campuran (belum dibaca & sudah dibaca) untuk riwayat
        $this->notifications = $admin->notifications()->latest()->take(10)->get()->toArray();
    }

    public function markAsRead($id)
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin) return;

        $notification = $admin->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            
            $this->refreshNotifs();
            $this->dispatch('notif-updated');
            
            if (isset($notification->data['url']) && !empty($notification->data['url']) && $notification->data['url'] !== '#') {
                return redirect($notification->data['url']);
            }
        }
    }

    public function markAllAsRead()
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin) return;

        $admin->unreadNotifications->markAsRead();
        $this->refreshNotifs();
        $this->dispatch('notif-updated');
    }

    public function render()
    {
        return view('livewire.admin.notification-dropdown');
    }
}
