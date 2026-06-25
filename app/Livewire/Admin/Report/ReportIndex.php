<?php

namespace App\Livewire\Admin\Report;

use Livewire\Component;
use Modules\Shop\Entities\Order;
use Carbon\Carbon;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan baris ini di atas
use Modules\Shop\Entities\OrderItem;
use Modules\Shop\Entities\Wishlist;
use Illuminate\Support\Facades\DB;

class ReportIndex extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function filter()
    {
        $this->resetPage();
    }

    public function export()
    {
        // 1. Ambil SEMUA data sesuai filter (jangan pakai paginate() agar semua ter-export)
        $query = Order::whereIn('status', ['PAID', 'PROCESSING', 'PACKAGING', 'DELIVERED', 'RECEIVED', 'COMPLETED'])
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate)
            ->orderBy('created_at', 'desc');

        $orders = $query->get();
        $totalRevenue = $query->sum('grand_total');
        $totalOrders = $query->count();

        // 2. Siapkan data yang mau dikirim ke file PDF
        $data = [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        // 3. Render HTML menjadi PDF menggunakan view yang baru dibuat
        $pdf = Pdf::loadView('livewire.admin.report.pdf', $data);

        // 4. Download file otomatis di browser pengguna
        $namaFile = 'Laporan_Penjualan_' . $this->startDate . '_sampai_' . $this->endDate . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $namaFile);
    }

    public function render()
    {
        $query = Order::whereIn('status', ['PAID', 'PROCESSING', 'PACKAGING', 'DELIVERED', 'RECEIVED', 'COMPLETED'])
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate);

        $totalRevenue = $query->sum('grand_total');
        $totalOrders = $query->count();
        
        $activeCustomers = Order::whereIn('status', ['PAID', 'PROCESSING', 'PACKAGING', 'DELIVERED', 'RECEIVED', 'COMPLETED'])
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate)
            ->distinct('user_id')
            ->count('user_id');

        $productsSold = OrderItem::whereHas('order', function ($q) {
            $q->whereIn('status', ['PAID', 'PROCESSING', 'PACKAGING', 'DELIVERED', 'RECEIVED', 'COMPLETED'])
              ->whereDate('created_at', '>=', $this->startDate)
              ->whereDate('created_at', '<=', $this->endDate);
        })->sum('qty');

        $topWishlists = Wishlist::select('product_id', DB::raw('count(*) as total'))
            ->with('product') // Relasi ke produk untuk mengambil nama dan gambar
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.report.report-index', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'activeCustomers' => $activeCustomers,
            'productsSold' => $productsSold,
            'topWishlists' => $topWishlists,
        ])->layout('components.layouts.app');
    }
}