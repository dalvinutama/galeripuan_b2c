<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Detail Pesanan
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/orders" wire:navigate class="btn btn-white">
                                Kembali
                            </a>
                        </span>
                        <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Cetak Invois
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Order</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-transparent table-responsive">
                                <tr>
                                    <td>No Order</td>
                                    <td><span class="fw-bold">#{{ $order->code }}</span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td><span class="fw-bold">{{ $order->order_date_formatted }}</span></td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td><span class="fw-bold">{{ $order->payment_method ?? 'Belum Memilih Metode' }}</span></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @php
                                            $statusIndo = [
                                                'CREATED' => 'Pesanan Baru',
                                                'PENDING' => 'Menunggu Pembayaran',
                                                'PAID' => 'Sudah Dibayar',
                                                'PROCESSING' => 'Sedang Diproses',
                                                'DELIVERED' => 'Sedang Dikirim',
                                                'RECEIVED' => 'Selesai / Diterima',
                                                'CANCELLED' => 'Dibatalkan Pelanggan'
                                            ];
                                            $teksStatus = $statusIndo[strtoupper($order->status)] ?? $order->status;
                                        @endphp
                                        <span class="badge badge-outline {{ $order->status_badge }}">{{ $teksStatus }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Catatan</td>
                                    <td><i>{{ $order->customer_note ?? 'Tidak ada catatan dari pelanggan' }}</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pengiriman</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-transparent table-responsive">
                                <tr>
                                    <td>Nama</td>
                                    <td><span class="fw-bold">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</span></td>
                                </tr>
                                <tr>
                                    <td>No Handphone</td>
                                    <td><span class="fw-bold">{{ $order->customer_phone }}</span></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><span class="fw-bold">{{ $order->customer_email }}</span></td>
                                </tr>
                                <tr>
                                    <td>Alamat Detail</td>
                                    <td><span class="fw-bold">{{ $order->customer_address1 }}</span></td>
                                </tr>
                                <tr>
                                    <td>No Resi</td>
                                    <td>
                                        @if($order->shipping_number)
                                            <span class="fw-bold">{{ $order->shipping_number }}</span>
                                            <a href="https://cekresi.com/?noresi={{ $order->shipping_number }}" target="_blank" class="ms-2 badge bg-primary text-decoration-none">Lacak Resi</a>
                                        @else
                                            <span class="text-muted"><i>Belum ada resi</i></span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kurir</td>
                                    <td><span class="fw-bold text-uppercase">{{ $order->shipping_courier }} ({{ $order->shipping_service_name }})</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Produk</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-transparent table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%"></th>
                                        <th>Produk</th>
                                        <th class="text-center" style="width: 1%">Qty</th>
                                        <th class="text-end" style="width: 15%">Satuan</th>
                                        <th class="text-end" style="width: 15%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="avatar me-3 rounded" style="background-image: url('{{ shop_product_image($item->product ? ($item->product->images->first() ?? ($item->product->parent ? $item->product->parent->images->first() : null)) : null) }}')"></span>
                                        </td>
                                        <td>
                                            <p class="strong mb-1">{{ $item->name }}</p>
                                            @if($item->attributes && is_array($item->attributes) && count($item->attributes) > 0)
                                                <div class="mb-2">
                                                    @foreach($item->attributes as $key => $value)
                                                        <span class="badge bg-label-secondary border me-1" style="font-size: 0.75rem;">
                                                            <span class="text-muted text-capitalize">{{ $key }}:</span> {{ $value }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="text-secondary">
                                                @if ($item->product && $item->product->sale_price > 0)
                                                    <span class="fw-bold">Rp {{ number_format($item->product->sale_price, 0, ',', '.') }}</span> <span><del>Rp {{ number_format($item->product->price, 0, ',', '.') }}</del></span>
                                                @elseif($item->product)
                                                    <span class="fw-bold">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($item->base_price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp {{ number_format($item->qty * $item->base_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    <tr>
                                        <td colspan="4" class="strong text-end">Subtotal Produk</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($order->base_total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="4" class="text-muted text-end">Ongkos Kirim</td>
                                        <td class="text-end text-muted">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                    </tr>

                                    @if($order->discount_amount > 0)
                                    <tr>
                                        <td colspan="4" class="text-danger text-end">Potongan Voucher</td>
                                        <td class="text-end text-danger">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td colspan="4" class="fw-bold text-uppercase text-end" style="color: #4A3F35;">
                                            Total Pembayaran {{ $order->payment_method ? '('.$order->payment_method.')' : '' }}
                                        </td>
                                        <td class="fw-bold text-end text-primary" style="font-size: 1.1rem;">
                                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center bg-light">
                            <span class="d-none d-sm-inline">
                                <a href="/admin/orders" wire:navigate class="btn btn-white">
                                    <i class="bx bx-arrow-back me-1"></i> Kembali
                                </a>
                            </span>
                            
                            <div class="text-end">
                                @php $currentStatus = strtoupper($order->status); @endphp
                                
                                @if(in_array($currentStatus, ['CREATED', 'PENDING']))
                                    <span class="text-danger fw-bold me-3" style="font-size: 13px;">
                                        <i class="bx bx-error-circle"></i> Menunggu Pembayaran Pelanggan
                                    </span>
                                    <button class="btn btn-secondary disabled" style="cursor: not-allowed;" title="Pesanan belum dibayar">
                                        <i class="bx bx-lock-alt me-1"></i> Terkunci
                                    </button>
                                    
                                @elseif($currentStatus == 'RECEIVED')
                                    <button class="btn btn-success disabled" style="cursor: not-allowed; opacity: 0.9;">
                                        <i class="bx bx-check-double me-1"></i> Pesanan Sudah Selesai dan Diterima
                                    </button>

                                @elseif($currentStatus == 'CANCELLED')
                                    <button class="btn btn-danger disabled" style="cursor: not-allowed; opacity: 0.9;">
                                        <i class="bx bx-x-circle me-1"></i> Pesanan Telah Dibatalkan
                                    </button>

                                @else
                                    <button wire:click="$dispatchTo('admin.order.order-update', 'show-order-action', { id: '{{ $order->id }}' })" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-order-update">
                                        <i class="bx bx-cog me-1"></i> Proses Pesanan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.order.order-update />
</div>
<script>
    document.addEventListener('livewire:init', () => {
        var myModal = new bootstrap.Modal(document.getElementById('modal-order-update'))
        Livewire.on('order-progress-updated', (event) => {
            myModal.hide()
        });

        Livewire.on('order-cancelled', (event) => {
            myModal.hide()
        });
    });
</script>