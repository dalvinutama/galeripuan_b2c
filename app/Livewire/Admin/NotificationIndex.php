<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class NotificationIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public function markAsRead($id)
    {
        $admin = auth()->guard('admin')->user();
        $notification = $admin->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            // Dispatch event untuk update lonceng di header
            $this->dispatch('notif-updated');
            
            if (isset($notification->data['url']) && $notification->data['url'] !== '#') {
                return redirect($notification->data['url']);
            }
        }
    }

    public function markAllAsRead()
    {
        auth()->guard('admin')->user()->unreadNotifications->markAsRead();
        $this->dispatch('notif-updated');
    }

    public function deleteNotification($id)
    {
        $admin = auth()->guard('admin')->user();
        $notification = $admin->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();
            $this->dispatch('notif-updated'); // Agar dropdown juga terupdate
        }
    }

    public function deleteAllRead()
    {
        $admin = auth()->guard('admin')->user();
        // Hanya hapus yang sudah dibaca (riwayat)
        $admin->notifications()->whereNotNull('read_at')->delete();
        $this->dispatch('notif-updated');
    }

    public function render()
    {
        $admin = auth()->guard('admin')->user();
        $notifications = $admin->notifications()->paginate(15);
        
        return view('livewire.admin.notification-index', [
            'notifications' => $notifications,
        ])->layout('components.layouts.app');
    }
}
