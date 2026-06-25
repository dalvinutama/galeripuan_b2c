<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ url('admin/customers') }}" wire:navigate>Data Konsumen</a> / Profil
                    </div>
                    <h2 class="page-title">Profil: {{ $customer->name }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="badge {{ $segmentBadge['class'] }} text-white px-3 py-2 fs-4">{{ $segmentBadge['text'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <span class="avatar avatar-xl mb-3 rounded" style="background-image: url('{{ asset('static/avatars/000m.jpg') }}')">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                            <h3 class="m-0 mb-1"><a href="#">{{ $customer->name }}</a></h3>
                            <div class="text-muted">{{ $customer->email }}</div>
                            <div class="mt-3">
                                <span class="badge bg-purple-lt">Total Belanja: Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="mailto:{{ $customer->email }}" class="card-btn">
                                <i class="bx bx-envelope me-2"></i> Email
                            </a>
                        </div>
                    </div>
                    
                    @if($favoriteProduct)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Produk Favorit (Sering Dibeli)</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <span class="avatar me-3 rounded" style="background-image: url('{{ shop_product_image($favoriteProduct ? ($favoriteProduct->images->first() ?? ($favoriteProduct->parent ? $favoriteProduct->parent->images->first() : null)) : null) }}')"></span>
                                <div>
                                    <div class="font-weight-medium">{{ $favoriteProduct->name }}</div>
                                    <div class="text-muted small">ID: {{ $favoriteProduct->sku }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ $activeTab == 'biodata' ? 'active' : '' }}" wire:click.prevent="setTab('biodata')">Biodata</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ $activeTab == 'orders' ? 'active' : '' }}" wire:click.prevent="setTab('orders')">Riwayat Pesanan ({{ $customer->orders->count() }})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ $activeTab == 'wishlist' ? 'active' : '' }}" wire:click.prevent="setTab('wishlist')">Wishlist ({{ $customer->wishlists->count() }})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ $activeTab == 'abandoned' ? 'active text-danger' : '' }}" wire:click.prevent="setTab('abandoned')">Keranjang Terbengkalai</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            @if($activeTab == 'biodata')
                                <h4>Informasi Dasar</h4>
                                <div class="mb-3">
                                    <strong>Nama Lengkap:</strong> {{ $customer->name }}<br>
                                    <strong>Email:</strong> {{ $customer->email }}<br>
                                    <strong>Bergabung Sejak:</strong> {{ $customer->created_at->format('d F Y H:i') }}<br>
                                </div>
                                <hr>
                                <h4>Alamat Tersimpan ({{ $customer->addresses->count() }})</h4>
                                @forelse($customer->addresses as $address)
                                    <div class="card mb-2 border">
                                        <div class="card-body p-3">
                                            <strong>{{ $address->first_name }} {{ $address->last_name }}</strong> 
                                            @if($address->is_primary) <span class="badge bg-primary ms-2">Utama</span> @endif
                                            <div class="text-muted mt-1">
                                                {{ $address->phone }}<br>
                                                {{ $address->address1 }}, {{ $address->address2 }}<br>
                                                {{ $address->city }}, {{ $address->province }} {{ $address->postcode }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada alamat tersimpan.</p>
                                @endforelse
                            
                            @elseif($activeTab == 'orders')
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>Kode Pesanan</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($customer->orders as $order)
                                                <tr>
                                                    <td>{{ $order->code }}</td>
                                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($order->status == 'PENDING' || $order->status == 'UNPAID')
                                                            <span class="badge bg-orange text-white">Pending</span>
                                                        @elseif($order->status == 'CONFIRMED' || $order->status == 'PROCESSING' || $order->status == 'PAID' || $order->status == 'PACKAGING')
                                                            <span class="badge bg-blue text-white">Diproses</span>
                                                        @elseif($order->status == 'DELIVERED')
                                                            <span class="badge bg-indigo text-white">Dikirim</span>
                                                        @elseif($order->status == 'RECEIVED')
                                                            <span class="badge bg-green text-white">Selesai</span>
                                                        @elseif($order->status == 'CANCELLED')
                                                            <span class="badge bg-red text-white">Dibatalkan</span>
                                                        @else
                                                            <span class="badge bg-secondary text-white">{{ $order->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/orders/' . $order->id) }}" class="btn btn-sm btn-light">Lihat</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">Belum ada riwayat pesanan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            
                            @elseif($activeTab == 'wishlist')
                                <div class="row g-3">
                                    @forelse($customer->wishlists as $wishlist)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center border p-2 rounded">
                                                <a href="{{ $wishlist->product ? route('admin.products.update', [$wishlist->product->id]) : '#' }}">
                                                    <span class="avatar me-3 rounded" style="background-image: url('{{ shop_product_image($wishlist->product ? ($wishlist->product->images->first() ?? ($wishlist->product->parent ? $wishlist->product->parent->images->first() : null)) : null) }}')"></span>
                                                </a>
                                                <div>
                                                    <div class="font-weight-medium">
                                                        <a href="{{ $wishlist->product ? route('admin.products.update', [$wishlist->product->id]) : '#' }}" class="text-primary fw-bold text-decoration-none">
                                                            {{ $wishlist->product->name ?? 'Produk Dihapus' }}
                                                        </a>
                                                    </div>
                                                    <div class="text-muted small">Ditambahkan: {{ $wishlist->created_at->format('d M Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center text-muted py-3">Belum ada produk di wishlist.</div>
                                    @endforelse
                                </div>
                            
                            @elseif($activeTab == 'abandoned')
                                <div class="alert alert-danger" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <i class="bx bx-error-circle me-2 icon alert-icon"></i>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Keranjang Terbengkalai (Abandoned Carts)</h4>
                                            <div class="text-muted">Ini adalah daftar keranjang belanja yang belum di-checkout oleh konsumen dan sudah tidak ada aktivitas selama lebih dari 24 jam.</div>
                                        </div>
                                    </div>
                                </div>

                                    @forelse($abandonedCarts as $cart)
                                    <div class="card mb-3 border-danger">
                                        <div class="card-header bg-danger-lt">
                                            <h4 class="card-title text-danger">Keranjang Tgl: {{ $cart->updated_at->format('d M Y H:i') }}</h4>
                                            <div class="card-actions">
                                                <span class="badge bg-danger text-white">Belum Checkout</span>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-vcenter mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cart->items as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="{{ $item->product ? route('admin.products.update', [$item->product->id]) : '#' }}">
                                                                        <span class="avatar me-2 rounded" style="background-image: url('{{ shop_product_image($item->product ? ($item->product->images->first() ?? ($item->product->parent ? $item->product->parent->images->first() : null)) : null) }}')"></span>
                                                                    </a>
                                                                    <a href="{{ $item->product ? route('admin.products.update', [$item->product->id]) : '#' }}" class="text-primary text-decoration-none fw-bold">
                                                                        {{ $item->product->name ?? 'Produk' }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->qty }}</td>
                                                            <td>Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2" class="text-end">Total Nilai Keranjang:</th>
                                                        <th>Rp {{ number_format($cart->base_total_price, 0, ',', '.') }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-3">Tidak ada keranjang terbengkalai.</div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
