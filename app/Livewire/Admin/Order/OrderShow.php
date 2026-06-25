<?php

namespace App\Livewire\Admin\Order;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shop\Entities\Order;

class OrderShow extends Component
{
    public $id;

    #[On('order-progress-updated')]
    #[On('order-cancelled')]
    public function refreshOrder()
    {
    }

    public function render()
    {
        $order = Order::findOrFail($this->id);

        $candUpdateProgress = true;
        
        $currentStatus = strtoupper($order->status);
        
        // HANYA Dibatalkan dan Diterima yang mematikan fitur update (DELIVERED dihapus dari sini)
        if (in_array($currentStatus, ['CANCELLED', 'RECEIVED'])) {
            $candUpdateProgress = false;
        }
    
        return view('livewire.admin.order.order-show', [
            'order' => $order,
            'canUpdateProgress' => $candUpdateProgress,
        ])->layout('components.layouts.app'); 
    }
}
