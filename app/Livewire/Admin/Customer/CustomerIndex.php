<?php

namespace App\Livewire\Admin\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Modules\Shop\Entities\Order;

class CustomerIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $segment = 'all';

    public function render()
    {
        $query = User::query();

        // Count base metrics
        $totalCustomers = User::count();
        $newCustomers = User::where('created_at', '>=', now()->subDays(30))->count();
        
        // Active customers: ordered in last 3 months
        $activeCustomers = User::whereHas('orders', function($q) {
            $q->where('created_at', '>=', now()->subMonths(3));
        })->count();

        // Loyal customers: > 3 orders
        $loyalCustomers = User::has('orders', '>', 3)->count();

        // Apply segmentation
        if ($this->segment === 'new') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($this->segment === 'active') {
            $query->whereHas('orders', function($q) {
                $q->where('created_at', '>=', now()->subMonths(3));
            });
        } elseif ($this->segment === 'loyal') {
            $query->has('orders', '>', 3);
        } elseif ($this->segment === 'inactive') {
            $query->whereDoesntHave('orders', function($q) {
                $q->where('created_at', '>=', now()->subMonths(3));
            });
        }

        $customers = $query->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.admin.customer.customer-index', compact(
            'customers', 'totalCustomers', 'newCustomers', 'activeCustomers', 'loyalCustomers'
        ))->layout('components.layouts.app');
    }

    public function setSegment($segment)
    {
        $this->segment = $segment;
        $this->resetPage();
    }
}
