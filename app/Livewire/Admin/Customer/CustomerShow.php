<?php

namespace App\Livewire\Admin\Customer;

use Livewire\Component;
use App\Models\User;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Cart;
use Modules\Shop\Entities\Product;

class CustomerShow extends Component
{
    public $customerId;
    public User $customer;
    public $activeTab = 'biodata';

    public function mount($id)
    {
        $this->customerId = $id;
        $this->customer = User::with([
            'orders' => function($q) {
                $q->orderBy('created_at', 'desc');
            },
            'addresses',
            'wishlists.product',
            'carts.items.product'
        ])->findOrFail($id);
    }

    public function render()
    {
        // Segment status
        $ordersCount = $this->customer->orders->count();
        $isLoyal = $ordersCount > 3;
        $isNew = $this->customer->created_at >= now()->subDays(30);
        
        $isActive = $this->customer->orders()->where('created_at', '>=', now()->subMonths(3))->exists();
        
        if ($isLoyal) {
            $segmentBadge = ['class' => 'bg-warning', 'text' => 'Loyal'];
        } elseif ($isNew) {
            $segmentBadge = ['class' => 'bg-success', 'text' => 'Baru'];
        } elseif ($isActive) {
            $segmentBadge = ['class' => 'bg-info', 'text' => 'Aktif'];
        } else {
            $segmentBadge = ['class' => 'bg-secondary', 'text' => 'Tidak Aktif'];
        }

        // Behavior Analytics
        $totalSpent = $this->customer->orders->where('status', '!=', Order::STATUS_CANCELLED)->sum('grand_total');
        
        // Favorite Product (Most ordered by this user)
        $favoriteProduct = null;
        $orderedProductIds = [];
        foreach ($this->customer->orders as $order) {
            foreach ($order->items as $item) {
                $orderedProductIds[] = $item->product_id;
            }
        }
        
        if (!empty($orderedProductIds)) {
            $vals = array_count_values($orderedProductIds);
            arsort($vals);
            $favoriteProductId = array_key_first($vals);
            $favoriteProduct = Product::find($favoriteProductId);
        }

        // Abandoned Carts
        $abandonedCarts = $this->customer->carts()->where('updated_at', '<', now()->subHours(24))->get();

        return view('livewire.admin.customer.customer-show', compact(
            'segmentBadge', 'totalSpent', 'favoriteProduct', 'abandonedCarts'
        ))->layout('components.layouts.app');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
}
