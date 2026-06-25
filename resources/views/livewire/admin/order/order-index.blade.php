<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Order
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Order</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex mb-5">
                                <div class="ms-auto text-muted">
                                    Cari:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" wire:model.live="search" class="form-control form-control-sm" aria-label="Search">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="table-responsive"> -->
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">Order</th>
                                        <th>Customer</th>
                                        <th>Products</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td class="align-text-top">
                                            <span class="fw-bold text-primary">{{ $order->code }}</span><br />
                                            <span class="text-muted" style="font-size: 12px;">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</span>
                                        </td>
                                        
                                        <td class="align-text-top">
                                            <span class="fw-bold">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</span><br />
                                            <span class="text-muted" style="font-size: 12px;">{{ strtoupper($order->shipping_courier) }} - {{ $order->shipping_service_name }}</span>
                                        </td>
                                        
                                        <td class="align-text-top">
                                            <ul class="list-unstyled mb-0" style="font-size: 13px;">
                                                @foreach ($order->items as $item)
                                                <li class="d-flex align-items-center mb-1">
                                                    <span class="avatar avatar-sm me-2 rounded" style="background-image: url('{{ shop_product_image($item->product ? ($item->product->images->first() ?? ($item->product->parent ? $item->product->parent->images->first() : null)) : null) }}')"></span>
                                                    {{ Str::words($item->name, 3) }}
                                                    @if($item->attributes && is_array($item->attributes) && count($item->attributes) > 0)
                                                        @foreach($item->attributes as $key => $value)
                                                            <span class="ms-1 badge bg-label-secondary" style="font-size: 0.65rem; padding: 0.2em 0.4em;">{{ $value }}</span>
                                                        @endforeach
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        
                                        <td class="align-text-top">
                                            <span class="fw-bold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span><br />
                                            <span class="text-muted d-block mb-1" style="font-size: 12px;">
                                                {{ $order->payment_method ? strtoupper($order->payment_method) : 'MIDTRANS' }}
                                            </span>
                                            
                                            @if(in_array(strtoupper($order->status), ['PAID', 'PROCESSING', 'PACKAGING', 'DELIVERED', 'RECEIVED']))
                                                <span class="badge bg-success text-white" style="font-size: 10px; padding: 3px 6px;">Lunas</span>
                                            @elseif(strtoupper($order->status) == 'CANCELLED')
                                                <span class="badge bg-danger text-white" style="font-size: 10px; padding: 3px 6px;">Batal</span>
                                            @else
                                                <span class="badge bg-warning text-dark" style="font-size: 10px; padding: 3px 6px;">Belum Lunas</span>
                                            @endif
                                        </td>
                                        
                                        <td class="align-text-top">
                                            @php
                                                $statusIndo = [
                                                    'CREATED' => 'Pesanan Baru',
                                                    'PENDING' => 'Menunggu Pembayaran',
                                                    'PAID' => 'Sudah Dibayar',
                                                    'PROCESSING' => 'Sedang Diproses',
                                                    'PACKAGING' => 'Sedang Dikemas', // <--- Ini perbaikan untuk status packaging yang lolos
                                                    'DELIVERED' => 'Sedang Dikirim',
                                                    'RECEIVED' => 'Selesai / Diterima',
                                                    'CANCELLED' => 'Dibatalkan Pelanggan'
                                                ];
                                                $teksStatus = $statusIndo[strtoupper($order->status)] ?? $order->status;
                                            @endphp
                                            <span class="badge badge-outline {{ $order->status_badge }}">{{ $teksStatus }}</span>
                                        </td>
                                        
                                        <td class="text-end align-text-top">
                                            <a wire:navigate href="{{ route('admin.orders.show', [$order->id]) }}" class="btn btn-outline-primary btn-sm btn-pill">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- </div> -->
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>