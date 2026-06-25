@extends('themes.gallerypuan.layouts.app')

@section('content')

<style>
    :root {
        --gold-primary: #c49a45;
        --gold-hover: #b38a36;
        --light-bg: #fdfcf9;
    }

    body {
        background-color: var(--light-bg);
    }

    /* Style Tab Container */
    .custom-tabs-container {
        display: flex;
        background: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 12px;
        padding: 6px;
        overflow-x: auto;
        white-space: nowrap;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    /* Style Masing-masing Tab */
    .custom-tab-item {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 170px;
        padding: 10px 16px;
        color: #6c757d;
        text-decoration: none;
        border-right: 1px solid #eaeaea;
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    .custom-tab-item:last-child {
        border-right: none;
    }

    /* Teks dalam Tab */
    .tab-text-wrapper {
        display: flex;
        flex-direction: column;
        margin-left: 10px;
    }
    .tab-title {
        font-weight: 700;
        font-size: 0.9rem;
        color: #333;
    }
    .tab-subtitle {
        font-size: 0.7rem;
        color: #888;
        margin-top: -2px;
    }

    /* Tab Aktif */
    .custom-tab-item.active {
        background: linear-gradient(135deg, var(--gold-primary), #d4af37);
        color: #ffffff;
        border-right: none;
        box-shadow: 0 4px 12px rgba(196, 154, 69, 0.3);
    }
    .custom-tab-item.active .tab-title,
    .custom-tab-item.active .tab-subtitle,
    .custom-tab-item.active i {
        color: #ffffff !important;
    }

    /* Ikon Judul Halaman */
    .page-icon-box {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--gold-primary);
        border-radius: 12px;
        color: var(--gold-primary);
        background-color: #fff;
    }

    /* Tombol */
    .btn-gold {
        background: var(--gold-primary);
        color: #fff;
        border-radius: 50px;
        padding: 10px 24px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
    }
    .btn-gold:hover {
        background: var(--gold-hover);
        color: #fff;
        transform: translateY(-2px);
    }

    /* LUXURY ORDER CARDS - LEVEL MAX */
    .luxury-order-card {
        background: #ffffff;
        border: 1px solid #f0e6d2; /* Border keemasan super halus */
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .luxury-order-card:hover {
        box-shadow: 0 15px 40px rgba(196, 154, 69, 0.15);
        transform: translateY(-5px);
        border-color: var(--gold-primary);
    }
    
    .loc-header {
        background: linear-gradient(135deg, #fdfbf7 0%, #f9f5eb 100%);
        padding: 16px 24px;
        border-bottom: 1px solid #f0e6d2;
    }
    .loc-date {
        color: #8c7a6b;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .loc-code {
        letter-spacing: 0.5px;
        font-size: 0.95rem;
        background: #fff;
        border: 1px solid #e0d5c1 !important;
        color: #555 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    
    .loc-body {
        padding: 24px;
        background: #ffffff;
    }

    .loc-product-img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .loc-price-summary {
        min-width: 160px;
    }

    .loc-chevron {
        font-size: 2rem;
        color: #d4af37;
        opacity: 0.3;
        transition: all 0.3s ease;
    }
    .luxury-order-card:hover .loc-chevron {
        opacity: 1;
        transform: translateX(5px);
    }
    
    @media (max-width: 768px) {
        .loc-body-content {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .loc-price-summary {
            border-start: none !important;
            padding-left: 0 !important;
            margin-left: 0 !important;
            text-align: left !important;
            margin-top: 15px;
            border-top: 1px dashed #eaeaea;
            padding-top: 15px;
            width: 100%;
        }
        .loc-chevron-container {
            display: none;
        }
    }
</style>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center">
            <div class="page-icon-box shadow-sm me-3">
                <i class="bx bx-shopping-bag fs-3"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-dark" style="font-family: 'Playfair Display', serif;">Riwayat Pesanan</h2>
                <p class="text-muted mb-0 small">Pantau status pengiriman dan riwayat belanja Anda di sini.</p>
            </div>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            
            <div class="custom-tabs-container mb-4">
                <a href="{{ route('profile.orders') }}" class="custom-tab-item {{ request('status') == null ? 'active' : '' }}">
                    <i class="bx bx-grid-alt fs-4 text-muted"></i>
                    <div class="tab-text-wrapper">
                        <span class="tab-title">Semua</span>
                        <span class="tab-subtitle">Seluruh pesanan</span>
                    </div>
                </a>

                <a href="{{ route('profile.orders', ['status' => 'unpaid']) }}" class="custom-tab-item {{ request('status') == 'unpaid' ? 'active' : '' }}">
                    <i class="bx bx-credit-card-front fs-4 text-muted"></i>
                    <div class="tab-text-wrapper">
                        <span class="tab-title">Belum Bayar</span>
                        <span class="tab-subtitle">Menunggu pembayaran</span>
                    </div>
                </a>

                <a href="{{ route('profile.orders', ['status' => 'dikemas']) }}" class="custom-tab-item {{ request('status') == 'dikemas' ? 'active' : '' }}">
                    <i class="bx bx-package fs-4 text-muted"></i>
                    <div class="tab-text-wrapper">
                        <span class="tab-title">Dikemas</span>
                        <span class="tab-subtitle">Sedang diproses</span>
                    </div>
                </a>

                <a href="{{ route('profile.orders', ['status' => 'dikirim']) }}" class="custom-tab-item {{ request('status') == 'dikirim' ? 'active' : '' }}">
                    <i class="bx bx-truck fs-4 text-muted"></i>
                    <div class="tab-text-wrapper">
                        <span class="tab-title">Dikirim</span>
                        <span class="tab-subtitle">Dalam perjalanan</span>
                    </div>
                </a>

                <a href="{{ route('profile.orders', ['status' => 'selesai']) }}" class="custom-tab-item {{ request('status') == 'selesai' ? 'active' : '' }}">
                    <i class="bx bx-check-circle fs-4 text-muted"></i>
                    <div class="tab-text-wrapper">
                        <span class="tab-title">Selesai</span>
                        <span class="tab-subtitle">Pesanan diterima</span>
                    </div>
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-5 px-3">
                            <img src="{{ asset('images/empty-bag-illustration.png') }}" alt="Belum ada pesanan" style="max-width: 200px;" class="mb-4">
                            <h4 class="fw-bold text-dark" style="font-family: 'Playfair Display', serif;">Belum ada pesanan di kategori ini.</h4>
                            <p class="text-muted mb-4">Yuk, temukan koleksi hijab premium favoritmu<br>dan buat penampilanmu semakin istimewa ✨</p>
                            <a href="{{ url('/products') }}" class="btn btn-gold shadow-sm">
                                <i class="bx bx-shopping-bag me-1"></i> Mulai Belanja <i class="bx bx-chevron-right"></i>
                            </a>
                        </div>
                    @else
                        <div class="order-cards-wrapper p-3" style="background: transparent;">
                            @foreach ($orders as $order)
                                @php
                                    $isExpired = \Carbon\Carbon::parse($order->created_at)->addHours(24)->isPast();
                                    $isUnpaid = in_array($order->status, ['created', 'unpaid', 'pending']);
                                    $firstItem = $order->items->first();
                                    $otherItemsCount = $order->items->count() - 1;
                                    
                                    $prod = $firstItem ? \Modules\Shop\Entities\Product::find($firstItem->product_id) : null;
                                    $parentProd = $prod && $prod->parent_id ? $prod->parent : null;
                                    $listImgObj = null;
                                    if($prod) {
                                        $listImgObj = $prod->images->first() ?? ($parentProd ? $parentProd->images->first() : null);
                                    }
                                @endphp
                                
                                <div class="luxury-order-card mb-4" onclick="window.location='{{ route('orders.show', $order->id) }}'" title="Klik untuk melihat detail pesanan">
                                    
                                  <!-- Header Card -->
                            <div class="loc-header d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="loc-date"><i class="bx bx-calendar-check me-1 fs-6"></i> Belanja &bull; {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</span>
                                    <span class="badge loc-code px-3 py-2 rounded-pill">{{ $order->code }}</span>
                                </div>
                                <div class="loc-status">
                                    @if($order->status == 'created' || $order->status == 'unpaid')
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm" style="background-color: #FFF5F5; color: #DC3545; border: 1px solid #DC3545;">Belum Bayar</span>
                                    @elseif($order->status == 'processing' || $order->status == 'packaging' || $order->status == 'confirmed')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #F0F8FF; color: #0D6EFD; border: 1px solid #0D6EFD;">Dikemas</span>
                                    @elseif($order->status == 'delivered' || $order->status == 'shipped')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #FFFBE6; color: #B8952E; border: 1px solid #B8952E;">Dikirim</span>
                                    @elseif($order->status == 'received' || $order->status == 'completed')
                                        <span class="badge rounded-pill px-3 py-2 shadow-sm" style="background-color: #F0FFF4; color: #198754; border: 1px solid #198754;">Selesai</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge rounded-pill bg-dark px-3 py-2">Dibatalkan</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary px-3 py-2">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Body Card -->
                            <div class="loc-body d-flex align-items-center">
                                <div class="loc-body-content d-flex align-items-center flex-grow-1">
                                    <div class="loc-image-container me-4">
                                        @if($firstItem)
                                            <img src="{{ shop_product_image($listImgObj) }}" alt="{{ $firstItem->name }}" class="loc-product-img">
                                        @else
                                            <div class="loc-product-img d-flex align-items-center justify-content-center bg-light text-muted">
                                                <i class="bx bx-image fs-1"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="loc-product-details flex-grow-1">
                                        @if($firstItem)
                                            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">{{ $firstItem->name }}</h5>
                                            @if($firstItem->attributes && is_array($firstItem->attributes) && count($firstItem->attributes) > 0)
                                                <div class="text-muted mb-1" style="font-size: 11px;">
                                                    @foreach($firstItem->attributes as $key => $val)
                                                        <span class="me-2">{{ ucfirst($key == 'color' ? 'Warna' : $key) }}: <span class="fw-semibold">{{ $val }}</span></span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <p class="text-muted mb-0" style="font-size: 0.95rem;">{{ $firstItem->qty }} produk &times; Rp {{ number_format($firstItem->price, 0, ',', '.') }}</p>
                                        @endif
                                        
                                        @if($otherItemsCount > 0)
                                            <div class="mt-2">
                                                <span class="badge px-3 py-1" style="background: #fdfaf5; color: #8c7a6b; font-weight: 600; font-size: 0.8rem; border: 1px solid #e0d5c1;">+ {{ $otherItemsCount }} produk lainnya</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="loc-price-summary text-end border-start ps-4 ms-3 pe-3">
                                        <p class="text-muted mb-1 small text-uppercase" style="letter-spacing: 1px; font-weight: 600;">Total Belanja</p>
                                        <h5 class="fw-bold mb-0" style="color: var(--gold-primary) !important; font-size: 1.4rem; font-family: 'Playfair Display', serif;">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                                <div class="loc-chevron-container ps-2">
                                    <i class="bx bx-chevron-right loc-chevron"></i>
                                </div>
                            </div>
                                    
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection