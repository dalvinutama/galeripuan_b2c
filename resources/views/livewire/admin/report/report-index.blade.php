<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Laporan Penjualan
                    </h2>
                    <p class="text-muted">Pantau pendapatan dan filter pesanan berdasarkan tanggal.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            
            @if (session()->has('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row row-deck row-cards">
                
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <form wire:submit.prevent="filter" class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" wire:model="startDate" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="date" wire:model="endDate" class="form-control" required>
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bx bx-filter-alt me-2"></i> Terapkan Filter
                                    </button>
                                    <button type="button" wire:click="export" class="btn btn-success w-100">
                                        <i class="bx bx-download me-2"></i> Export Excel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-success border-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader fw-bold text-success">Pendapatan</div>
                            </div>
                            <div class="h2 mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-primary border-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader fw-bold text-primary">Pesanan Sukses</div>
                            </div>
                            <div class="h2 mb-0 fw-bold">{{ $totalOrders }} <span class="fs-5 text-muted fw-normal">Trx</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-info border-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader fw-bold text-info">Pelanggan Belanja</div>
                            </div>
                            <div class="h2 mb-0 fw-bold">{{ number_format($activeCustomers, 0, ',', '.') }} <span class="fs-5 text-muted fw-normal">Orang</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-warning border-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="subheader fw-bold text-warning">Hijab Terjual</div>
                            </div>
                            <div class="h2 mb-0 fw-bold">{{ number_format($productsSold, 0, ',', '.') }} <span class="fs-5 text-muted fw-normal">Pcs</span></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-12 mt-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header border-0">
                            <h3 class="card-title">Rincian Transaksi</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No. Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status</th>
                                        <th>Total Belanja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $order->code }}</span>
                                        </td>
                                        <td class="text-secondary">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}
                                        </td>
                                        <td>
                                            {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                                        </td>
                                        <td class="text-secondary">
                                            {{ strtoupper($order->payment_method ?? 'MIDTRANS') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ $order->status }}</span>
                                        </td>
                                        <td class="fw-bold">
                                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            Belum ada data transaksi pada rentang tanggal tersebut.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mt-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-bottom py-3 flex-column align-items-start">
                            <h3 class="card-title mb-1 fw-bold"><i class="bx bxs-heart text-danger me-1"></i> Top 5 Produk Diminati</h3>
                            <p class="text-muted small mb-0" style="font-size: 12px; line-height: 1.4;">
                                Daftar hijab yang paling banyak dimasukkan ke <i>Wishlist</i> sepanjang waktu.
                            </p>
                        </div>
                        <div class="list-group list-group-flush">
                            @forelse($topWishlists as $wish)
                                @if($wish->product)
                                <div class="list-group-item py-3">
                                    <div class="d-flex align-items-start mb-2">
                                        <div class="me-3">
                                            @if($wish->product->images && $wish->product->images->first())
                                                <img src="{{ shop_product_image($wish->product->images->first()) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px; border-radius: 8px;">
                                                    <i class="bx bx-image fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-fill">
                                            <div class="fw-bold text-dark text-wrap mb-1" style="font-size: 13px; line-height: 1.2;">{{ $wish->product->name }}</div>
                                            <div class="text-muted" style="font-size: 11px;">SKU: <span class="fw-medium text-dark">{{ $wish->product->sku ?? '-' }}</span></div>
                                        </div>
                                        <div class="ms-2 text-end">
                                            <span class="badge bg-danger-lt text-danger fw-bold px-2 py-1" style="font-size: 11px; border-radius: 6px;">
                                                <i class="bx bxs-heart"></i> {{ $wish->total }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2" style="border-top: 1px dashed #E1DDD7;">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 12px;">Rp {{ number_format($wish->product->price, 0, ',', '.') }}</span>
                                            <span class="small" style="font-size: 11px;">
                                                Status: 
                                                <span class="fw-bold {{ strtolower($wish->product->stock_status_label) == 'out of stock' ? 'text-danger' : 'text-success' }}">
                                                    {{ $wish->product->stock_status_label ?? 'Tersedia' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <div class="list-group-item text-center py-5 text-muted border-0 bg-light m-3 rounded" style="border: 1px dashed #ccc !important;">
                                    <i class="bx bx-heart fs-1 mb-2 opacity-50"></i><br>
                                    <span class="fw-bold">Data Masih Kosong</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>