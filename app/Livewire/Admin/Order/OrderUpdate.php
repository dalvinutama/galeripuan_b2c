<?php

namespace App\Livewire\Admin\Order;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Shop\Entities\Order;
use Livewire\Attributes\On;
use Modules\Shop\Entities\ProductInventory;

class OrderUpdate extends Component
{
    public $action_note, $shipping_number;
    public $action_button_label = 'CONFIRM';
    public $order_status = '';
    public Order $order;
    public $nextActionType = '';
    public $nextAction = [];

    public function rules()
    {
        $rules = [
            'action_note' => 'nullable|string|max:255',
        ];

        if ($this->nextActionType === Order::ACTION_DELIVER) {
            $rules['shipping_number'] = 'required|string|max:255';
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.admin.order.order-update');
    }

    #[On('show-order-action')]
    public function findOrder($id)
    {
        $this->order = Order::findOrFail($id);
        
        $this->nextAction = $this->order->getNextActionAndStatus();

        $this->action_button_label = $this->nextAction['action_label'];
        $this->order_status = $this->nextAction['status'];
        $this->nextActionType = $this->nextAction['action'];
        $this->shipping_number = $this->order->shipping_number ?? '';
    }

    public function close()
    {
        $this->reset();
    }
// TAMBAHKAN FUNGSI INI
    public function cancel()
    {
        $this->reset(); // Ini akan membersihkan form dan menutup modal
    }
    public function update()
    {
        if (!$this->nextAction) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Tidak ada proses yang bisa dilakukan pada order ini.');
        }

        $params = $this->validate();
        $params['next_action'] = $this->nextAction;
        if ($this->updateProgress($this->order, $params)) {
            $this->dispatch('order-progress-updated');
            session()->flash('success', 'Status order berhasil diperbarui.');
            $this->reset();
            return;
        }

        session()->flash('error', 'Gagal memperbarui status order. Silakan coba lagi.');
    }

    private function updateProgress(Order $order, array $params)
    {
        DB::beginTransaction();
        try {
            $prevStatus = $order->getOriginal('status');
            $order->status = $params['next_action']['status'];
            if ($params['next_action']['action'] === Order::ACTION_DELIVER) {
                $order->shipping_number = $params['shipping_number'];
            }
            
            $order->save();

            $user = \App\Models\User::find($order->user_id);
            $admins = \App\Models\Admin::all();

            // --- NOTIFIKASI PESANAN DIKIRIM ---
            if ($order->status == 'delivered' || $order->status == Order::STATUS_DELIVERED) {
                if ($user) {
                    $user->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dikirim', "Pesanan #{$order->code} sedang dikirim dengan no resi: {$order->shipping_number}"));
                    if (!empty($order->shipping_number)) {
                        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ShippingTrackingMail($order));
                    }
                }
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dikirim', "Pesanan #{$order->code} telah dikirim dengan no resi: {$order->shipping_number}.", '/admin/orders/' . $order->id));
                }
            }

            // --- NOTIFIKASI PESANAN DIKONFIRMASI ---
            if ($prevStatus == 'pending' && ($order->status == 'confirmed' || $order->status == Order::STATUS_CONFIRMED)) {
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dikonfirmasi', "Pesanan #{$order->code} telah dikonfirmasi dan siap diproses.", '/admin/orders/' . $order->id));
                }
            }

            // --- NOTIFIKASI PESANAN DIKEMAS ---
            if ($prevStatus == 'confirmed' && ($order->status == 'packed' || $order->status == Order::STATUS_PACKED)) {
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dikemas', "Pesanan #{$order->code} sedang dikemas.", '/admin/orders/' . $order->id));
                }
            }
            
            // --- NOTIFIKASI BATAL OLEH ADMIN ---
            if ($order->status == 'cancelled' || $order->status == Order::STATUS_CANCELLED) {
                if ($user) {
                    $user->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dibatalkan', "Mohon maaf, pesanan #{$order->code} telah dibatalkan oleh pihak kami."));
                }
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dibatalkan', "Pesanan #{$order->code} telah dibatalkan oleh admin.", '/admin/orders/' . $order->id));
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal memperbarui status order: ' . $e->getMessage());
            return false;
        }

        return true;
    }


    
    // PERBAIKAN 2: FUNGSI LAMA nextActionAndStatus DI BAWAH INI SUDAH SAYA HAPUS.
}