@extends('themes.gallerypuan.layouts.app')

@section('content')
<style>
    /* Global Typography & Soft Background */
    .checkout-page {
        background-color: #FAF8F5;
        font-family: 'Poppins', sans-serif;
        color: #333333;
    }
    .text-luxury {
        color: #4A3F35;
    }
    .text-gold {
        color: #BC9C6C;
    }
    
    /* Breadcrumb Custom */
    .breadcrumb-section {
        background-color: #FAF8F5;
    }
    .breadcrumb-item a {
        color: #8C7A6B;
        text-decoration: none;
        transition: color 0.3s;
    }
    .breadcrumb-item a:hover {
        color: #BC9C6C;
    }
    .breadcrumb-item.active {
        color: #4A3F35;
        font-weight: 500;
    }

    /* Elegant Page Header */
    .checkout-header-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #4A3F35;
        letter-spacing: 0.5px;
        position: relative;
    }

    /* Premium Cards Styling */
    .premium-card {
        background: #FFFFFF;
        border: 1px solid #EFEBE7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(74, 63, 53, 0.03);
        transition: all 0.3s ease;
    }
    .premium-card:hover {
        box-shadow: 0 6px 24px rgba(74, 63, 53, 0.06);
    }
    .card-heading {
        font-size: 16px;
        font-weight: 600;
        color: #4A3F35;
        letter-spacing: 0.3px;
    }

    /* Address Selection Cards - FULLY CLICKABLE */
    .address-box {
        border: 1px solid #EFEBE7;
        border-radius: 12px;
        background: #FFFFFF;
        transition: all 0.3s ease;
        position: relative;
        display: block; /* Important for label */
        cursor: pointer;
    }
    .address-box:hover {
        border-color: #D1C7BD;
        background-color: #FCFAF7;
    }
    .address-box.primary-active {
        border-color: #BC9C6C;
        background-color: #FCFAF7;
        box-shadow: 0 4px 12px rgba(188, 156, 108, 0.1);
    }
    .address-label-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        background: #EFEBE7;
        color: #4A3F35;
    }
    .address-box.primary-active .address-label-badge {
        background: #4A3F35;
        color: #FFFFFF;
    }
    .primary-text-indicator {
        font-size: 12px;
        font-weight: 600;
        color: #BC9C6C;
    }

    /* Action Icon Buttons */
    .btn-icon-light {
        background: #FAF8F5;
        color: #8C7A6B;
        border: 1px solid #EFEBE7;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-icon-light:hover {
        background: #EFEBE7;
        color: #4A3F35;
    }
    .btn-icon-danger-outline {
        background: transparent;
        color: #DC3545;
        border: 1px solid #F8D7DA;
        padding: 5px 8px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-icon-danger-outline:hover {
        background: #DC3545;
        color: #FFFFFF;
        border-color: #DC3545;
    }

    /* Custom Selectable Courier Options */
    .courier-selector-group {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
    @media (max-width: 576px) {
        .courier-selector-group {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .courier-card-option {
        border: 1px solid #EFEBE7;
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        background: #FFFFFF;
        cursor: pointer;
        transition: all 0.25s ease;
        display: block;
        margin-bottom: 0;
    }
    .courier-card-option:hover {
        border-color: #BC9C6C;
        background: #FAF8F5;
    }
    .courier-code:checked + .courier-card-option {
        border-color: #4A3F35;
        background: #4A3F35;
        color: #FFFFFF !important;
        box-shadow: 0 4px 12px rgba(74, 63, 53, 0.15);
    }
    .courier-card-option span {
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    /* Custom Style Custom Checkbox Inputs */
    .form-check-input:checked {
        background-color: #4A3F35;
        border-color: #4A3F35;
    }

    /* Opsi Layanan Clickable */
    .available-services .list-group-item {
        cursor: pointer;
        transition: background-color 0.2s;
        padding: 0; /* Reset padding to allow label to take full space */
    }
    .available-services .list-group-item:hover {
        background-color: #FAF8F5 !important;
    }
    .available-services label {
        cursor: pointer;
        width: 100%;
        display: block;
        padding: 0.5rem 1rem; /* Move padding here */
        margin: 0;
    }

    /* Order Summary Sidebar & Sticky Logic */
    .sticky-sidebar {
        position: -webkit-sticky;
        position: sticky;
        top: 40px;
        z-index: 100;
    }
    .product-thumbnail {
        width: 64px;
        height: 76px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #EFEBE7;
    }

    /* Voucher & Wallet Section Layouts */
    .voucher-wallet-btn {
        background: #FFFFFF;
        border: 1px dashed #BC9C6C;
        color: #4A3F35;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .voucher-wallet-btn:hover:not([disabled]) {
        background: #FCFAF7;
        border-style: solid;
        transform: translateY(-1px);
    }
    .voucher-wallet-btn:disabled {
        border-color: #D1C7BD;
        background-color: #F5F3F0;
        color: #8C7A6B;
    }

    /* Elegant Buttons Styling */
    .btn-luxury-primary {
        background-color: #4A3F35;
        color: #FFFFFF;
        border: 1px solid #4A3F35;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 14px rgba(74, 63, 53, 0.18);
        transition: all 0.3s ease;
    }
    .btn-luxury-primary:hover {
        background-color: #382F27;
        border-color: #382F27;
        color: #FFFFFF;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 63, 53, 0.25);
    }
    .btn-luxury-outline {
        background-color: transparent;
        color: #8C7A6B;
        border: 1px solid #D1C7BD;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .btn-luxury-outline:hover {
        background-color: #FAF8F5;
        border-color: #4A3F35;
        color: #4A3F35;
    }
</style>

<div class="checkout-page pb-5">
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="py-4 border-bottom border-1 border-light border-opacity-10">
                        <h2 class="checkout-header-title mb-1">Penyelesaian Pesanan</h2>
                        <p class="text-muted small mb-0">Pastikan informasi alamat dan jasa ekspedisi sudah sesuai sebelum melakukan pembayaran.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7 col-12">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4 p-3" style="border-radius: 12px;">
                                <div class="fw-bold mb-1"><i class='bx bx-error-circle align-middle me-1 fs-5'></i> Periksa kembali isian Anda:</div>
                                <ul class="mb-0 px-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger border-0 shadow-sm mb-4 p-3 d-flex align-items-center gap-2 fw-semibold" style="border-radius: 12px; color: #842029; background-color: #f8d7da;">
                                <i class='bx bx-error-circle fs-4'></i> <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="premium-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-heading mb-0"><i class='bx bx-map text-gold me-2 fs-5 align-middle'></i>Alamat Pengiriman</h5>
                                <button type="button" class="btn btn-icon-light px-3" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">
                                    <i class='bx bx-plus me-1'></i> Tambah Alamat Baru
                                </button>
                            </div>

                            <div class="row g-3">
                                @forelse ($addresses as $address)
                                <div class="col-md-6 col-12">
                                    <label class="address-box p-3 h-100 {{ ($address->is_primary) ? 'primary-active' : '' }}" for="homeRadio{{ $address->id }}">
                                        
                                        <div class="position-absolute top-0 end-0 m-2 d-flex gap-1" style="z-index: 10;">
                                            <button type="button" class="btn btn-icon-light p-1 px-2" data-bs-toggle="modal" data-bs-target="#editAlamatModal{{ $address->id }}" title="Ubah Alamat" onclick="event.preventDefault();">
                                                <i class='bx bx-edit small'></i> <span style="font-size: 11px;">Ubah</span>
                                            </button>
                                            <button type="button" class="btn btn-icon-danger-outline p-1 px-2" title="Hapus Alamat" onclick="confirmLuxury(event, 'delete-form-{{ $address->id }}', 'Hapus Alamat', 'Yakin ingin menghapus alamat ini secara permanen?', 'trash')">
                                                <i class='bx bx-trash small'></i>
                                            </button>
                                        </div>

                                        <div class="form-check mb-3 mt-1">
                                            <input class="form-check-input delivery-address" value="{{ $address->id }}" type="radio" name="address_id" id="homeRadio{{ $address->id }}" {{ ($address->is_primary) ? 'checked' : '' }} style="cursor: pointer;">
                                            <span class="text-luxury fw-bold ms-1" style="font-size: 14px;">
                                                <span class="address-label-badge me-1">{{ $address->label }}</span>
                                            </span>
                                        </div>

                                        <address class="mb-2 text-muted small lh-lg" style="padding-left: 24px;">
                                            <strong class="text-dark d-block mb-1" style="font-size: 14px;">{{ $address->first_name }} {{ $address->last_name }}</strong>
                                            {{ $address->address1 }}<br>
                                            {{ $address->city }}, {{ $address->province }}<br>
                                            <span class="text-dark fw-medium"><i class='bx bx-phone me-1 small'></i>{{ $address->phone }}</span>
                                        </address>

                                        @if ($address->is_primary)
                                        <div class="pt-2 border-top border-light border-opacity-10 text-end" style="padding-left: 24px;">
                                            <span class="primary-text-indicator"><i class='bx bxs-check-shield me-1'></i>Alamat Utama</span>
                                        </div>
                                        @endif
                                    </label>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="p-4 text-center border rounded-3 bg-white text-muted small">
                                        <i class='bx bx-map-pin fs-3 d-block mb-2 text-gold opacity-50'></i>
                                        Belum ada alamat terdaftar. Silakan tambah alamat pengiriman baru terlebih dahulu.
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="premium-card p-4 mb-4">
                            <h5 class="card-heading mb-3"><i class='bx bxs-truck text-gold me-2 fs-5 align-middle'></i>Jasa Pengiriman / Ekspedisi</h5>
                            <p class="text-muted small mb-3">Pilih salah satu layanan ekspedisi resmi yang tersedia di bawah ini:</p>
                            
                            <div class="courier-selector-group">
                                <div>
                                    <input class="form-check-input courier-code d-none" type="radio" name="courier" id="inlineRadio1" value="jne" {{ old('courier') == 'jne' ? 'checked' : '' }}>
                                    <label class="courier-card-option" for="inlineRadio1"><span>JNE</span></label>
                                </div>
                                <div>
                                    <input class="form-check-input courier-code d-none" type="radio" name="courier" id="inlineRadio2" value="pos" {{ old('courier') == 'pos' ? 'checked' : '' }}>
                                    <label class="courier-card-option" for="inlineRadio2"><span>POS INDO</span></label>
                                </div>
                                <div>
                                    <input class="form-check-input courier-code d-none" type="radio" name="courier" id="inlineRadio3" value="tiki" {{ old('courier') == 'tiki' ? 'checked' : '' }}>
                                    <label class="courier-card-option" for="inlineRadio3"><span>TIKI</span></label>
                                </div>
                                <div>
                                    <input class="form-check-input courier-code d-none" type="radio" name="courier" id="inlineRadioJnt" value="jnt" {{ old('courier') == 'jnt' ? 'checked' : '' }}>
                                    <label class="courier-card-option" for="inlineRadioJnt"><span>J&T</span></label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="fw-semibold text-luxury small mb-2">Pilihan Opsi Paket Layanan:</label>
                                <div class="p-3 bg-light rounded-3 border border-1 border-light border-opacity-10">
                                    <ul class="list-group list-group-flush available-services" style="display: none; --bs-list-group-bg: transparent;"></ul>
                                    <div class="empty-service-placeholder text-muted small py-2"><i class='bx bx-info-circle me-1 text-gold'></i>Silakan pilih ekspedisi di atas untuk melihat tarif dan estimasi pengiriman.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-4">
                            <a href="{{ route('carts.index') }}" class="btn btn-luxury-outline order-2 order-sm-1 w-100 w-sm-auto">
                                <i class='bx bx-arrow-back me-1'></i> Kembali ke Keranjang
                            </a>
                            <button type="submit" class="btn btn-luxury-primary order-1 order-sm-2 w-100 w-sm-auto px-5">
                                <i class='bx bx-credit-card me-1'></i> Konfirmasi & Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5 col-12">
                    <div class="sticky-sidebar">
                        <div class="premium-card p-4 border-0 shadow">
                            <h5 class="card-heading border-bottom pb-3 mb-3"><i class='bx bx-receipt text-gold me-2 fs-5 align-middle'></i>Ringkasan Detail Pesanan</h5>
                            
                            <ul class="list-group list-group-flush mb-4" style="max-height: 280px; overflow-y: auto;">
                                @foreach ($cart->items as $item)
                                <li class="list-group-item py-3 px-0 bg-transparent border-light border-opacity-50">
                                    <div class="row g-2 align-items-center">
                                        @php
                                            $product = $item->product;
                                            $parentProduct = $product->parent_id ? $product->parent : null;
                                            $productLink = $parentProduct ? shop_product_link($parentProduct) : shop_product_link($product);
                                            $productImageObj = $product->images->first() ?? ($parentProduct ? $parentProduct->images->first() : null);
                                        @endphp
                                        <div class="col-auto">
                                            <img src="{{ shop_product_image($productImageObj, 'img-thumb') }}" alt="{{ $item->product->name }}" class="product-thumbnail shadow-sm">
                                        </div>
                                        <div class="col flex-grow-1 ps-2">
                                            <a href="{{ $productLink }}" class="text-decoration-none text-luxury fw-semibold small d-block mb-1 line-clamp-1">
                                                {{ $item->product->name }}
                                            </a>
                                            @if($item->attributes && count($item->attributes) > 0)
                                                <div class="text-muted" style="font-size: 11px; margin-bottom: 2px;">
                                                    @foreach($item->attributes as $key => $val)
                                                        <span class="me-2">{{ ucfirst($key == 'color' ? 'Warna' : $key) }}: <span class="fw-semibold">{{ $val }}</span></span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="text-muted" style="font-size: 12px;">
                                                @if ($item->product->has_sale_price)
                                                    <span class="text-dark fw-medium">Rp {{ $item->product->sale_price_label }}</span>
                                                    <span class="text-decoration-line-through text-muted ms-1" style="font-size: 11px;">{{ $item->product->price_label }}</span>
                                                @else
                                                    <span class="text-dark fw-medium">Rp {{ $item->product->price_label }}</span>
                                                @endif
                                                <span class="badge bg-light text-muted border ms-2">x{{ $item->qty }}</span>
                                            </div>
                                        </div>
                                        <div class="col-auto text-end">
                                            @if ($item->product->has_sale_price)
                                                <span class="text-luxury fw-bold small">Rp {{ $item->product->sale_price_label }}</span>
                                            @else
                                                <span class="text-luxury fw-bold small">Rp {{ $item->product->price_label }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                            <div class="p-3 mb-4 rounded-3" style="background: #FAF8F5; border: 1px solid #EFEBE7;">
                                <label class="form-label fw-bold text-luxury small mb-2"><i class='bx bxs-voucher text-gold me-1'></i> Voucher Gallery Puan</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn voucher-wallet-btn d-flex justify-content-between align-items-center p-2 px-3 flex-grow-1" id="btn-pilih-voucher" data-bs-toggle="modal" data-bs-target="#modalPilihVoucher" {{ $cart->voucher_code ? 'disabled' : '' }}>
                                        <span class="fw-semibold small mb-0" id="voucher-btn-text">
                                            @if($cart->voucher_code)
                                                <i class='bx bxs-check-circle text-success align-middle me-1 fs-5'></i> Voucher Dipakai: <span class="badge bg-dark ms-1">{{ $cart->voucher_code }}</span>
                                            @else
                                                Gunakan Voucher Promo
                                            @endif
                                        </span>
                                        <i class='bx bx-chevron-right fs-5 text-muted align-middle'></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-danger px-3 d-flex align-items-center justify-content-center" id="btn-remove-voucher" onclick="removeVoucher()" style="border-radius: 12px; {{ $cart->voucher_code ? '' : 'display: none !important;' }}" title="Batalkan Voucher">
                                        <i class='bx bx-x fs-4'></i>
                                    </button>
                                </div>
                                <div id="voucher-message" class="mt-2 small fw-bold"></div>
                            </div>

                            <div class="border-bottom border-light border-opacity-50 pb-2 mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
                                    <div>Total Harga Produk</div>
                                    <div class="fw-medium text-dark">Rp {{ $cart->base_total_price_label }}</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
                                    <div>Pajak Layanan (11%)</div>
                                    <div class="fw-medium text-dark">Rp {{ $cart->tax_amount_label }}</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
                                    <div>Ongkos Kirim Paket</div>
                                    <div class="fw-medium text-dark" id="shipping-fee">Rp 0</div>
                                </div>
                                
                                <div class="align-items-center justify-content-between mt-2 pt-2 border-top border-success border-opacity-10 text-success" id="voucher-discount-row" style="{{ $cart->voucher_code ? 'display: flex;' : 'display: none;' }}">
                                    <div class="small fw-semibold"><i class='bx bxs-voucher me-1'></i> Potongan Voucher</div>
                                    <div class="fw-bold fs-6" id="discount-amount">- Rp {{ $cart->discount_amount_label }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between py-2">
                                <div class="text-luxury fw-bold">Total Pembayaran</div>
                                <div class="text-luxury fw-bold fs-4" id="grand-total" style="font-family: 'Playfair Display', serif; color: #4A3F35;">Rp {{ $cart->grand_total_label }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header p-4 border-light border-opacity-50">
                <h5 class="modal-title fw-bold text-luxury" id="tambahAlamatModalLabel"><i class='bx bx-map-pin text-gold me-2 fs-4 align-middle'></i>Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.checkout.address.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-light bg-opacity-25">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Label Alamat</label>
                            <select name="label" class="form-select border-light p-2.5" style="border-radius: 10px;">
                                <option value="Rumah">Rumah (Tempat Tinggal)</option>
                                <option value="Kantor">Kantor (Tempat Kerja)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">No. Telepon / WA *</label>
                            <input type="text" name="phone" class="form-control p-2.5" placeholder="Contoh: 08123456789" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Nama Depan *</label>
                            <input type="text" name="first_name" class="form-control p-2.5" value="{{ auth()->user()->name }}" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Nama Belakang</label>
                            <input type="text" name="last_name" class="form-control p-2.5" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Provinsi *</label>
                            <select name="province" class="form-select province-select p-2.5" data-target="#citySelectAdd" style="border-radius: 10px;" required>
                                <option value="">Loading Data Provinsi...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Kota / Kabupaten *</label>
                            <select name="city" class="form-select p-2.5" id="citySelectAdd" style="border-radius: 10px;" required>
                                <option value="">Pilih Provinsi Terlebih Dahulu</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold text-luxury">Alamat Lengkap *</label>
                            <textarea name="address1" class="form-control" rows="2" placeholder="Nama Jalan, Blok, Nomor Rumah, RT/RW, dan Patokan Detail" style="border-radius: 10px;" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-luxury">Kode Pos *</label>
                            <input type="number" name="postcode" class="form-control p-2.5" style="border-radius: 10px;" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 border-light border-opacity-50">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-luxury-primary py-2 px-4" style="border-radius: 10px; box-shadow: none;">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($addresses as $address)
<div class="modal fade" id="editAlamatModal{{ $address->id }}" tabindex="-1" aria-labelledby="editAlamatModalLabel{{ $address->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header p-4 border-light border-opacity-50">
                <h5 class="modal-title fw-bold text-luxury" id="editAlamatModalLabel{{ $address->id }}"><i class='bx bx-edit text-gold me-2 fs-4 align-middle'></i>Ubah Data Alamat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.checkout.address.update', $address->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-light bg-opacity-25">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Label Alamat</label>
                            <select name="label" class="form-select border-light p-2.5" style="border-radius: 10px;">
                                <option value="Rumah" {{ $address->label == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                <option value="Kantor" {{ $address->label == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                                <option value="Lainnya" {{ $address->label == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">No. Telepon / WA *</label>
                            <input type="text" name="phone" class="form-control p-2.5" value="{{ $address->phone }}" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Nama Depan *</label>
                            <input type="text" name="first_name" class="form-control p-2.5" value="{{ $address->first_name }}" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Nama Belakang</label>
                            <input type="text" name="last_name" class="form-control p-2.5" value="{{ $address->last_name }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Provinsi *</label>
                            <select name="province" class="form-select province-select p-2.5" data-target="#citySelect{{ $address->id }}" data-selected="{{ $address->province_id }}|{{ $address->province }}" style="border-radius: 10px;" required>
                                <option value="">Loading Data Provinsi...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-luxury">Kota / Kabupaten *</label>
                            <select name="city" class="form-select p-2.5" id="citySelect{{ $address->id }}" data-selected="{{ $address->city_id }}|{{ $address->city }}" style="border-radius: 10px;" required>
                                <option value="">Pilih Provinsi Terlebih Dahulu</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold text-luxury">Alamat Lengkap *</label>
                            <textarea name="address1" class="form-control" rows="2" style="border-radius: 10px;" required>{{ $address->address1 }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-luxury">Kode Pos *</label>
                            <input type="number" name="postcode" class="form-control p-2.5" value="{{ $address->postcode }}" style="border-radius: 10px;" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 border-light border-opacity-50">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-luxury-primary py-2 px-4" style="border-radius: 10px; box-shadow: none;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form-{{ $address->id }}" action="{{ route('orders.checkout.address.destroy', $address->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach

<div class="modal fade" id="modalPilihVoucher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-white border-bottom p-4">
                <h5 class="modal-title fw-bold text-luxury"><i class='bx bx-purchase-tag-alt text-gold me-2 fs-4 align-middle'></i>Voucher Tersedia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #FAF8F5;">
                <div class="d-flex flex-column gap-3">
                    @forelse($vouchers as $voucher)
                        <div class="card border-0 shadow-sm {{ $voucher->is_eligible ? 'bg-white' : 'bg-opacity-40 bg-secondary bg-opacity-10' }}" 
                            style="border-radius: 14px; border-left: 5px solid {{ $voucher->is_eligible ? '#4A3F35' : '#adb5bd' }} !important; overflow: hidden;">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="pe-3">
                                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                            <h5 class="mb-0 fw-bold {{ $voucher->is_eligible ? 'text-luxury' : 'text-muted' }}" style="letter-spacing: 0.5px; font-size: 16px;">
                                                {{ $voucher->code }}
                                            </h5>
                                            @if($voucher->is_first_order_only) 
                                                <span class="badge bg-opacity-10 text-luxury border border-secondary" style="font-size: 10px; background-color: #EFEBE7;">Pengguna Baru</span> 
                                            @endif
                                            @if($voucher->min_order_count > 0)
                                                <span class="badge bg-dark text-white" style="font-size: 10px;">Pesanan Ke-{{ $voucher->min_order_count }}</span>
                                            @endif
                                        </div>
                                        <div class="text-muted mb-2" style="font-size: 12px; line-height: 1.4;">
                                            {{ $voucher->description ?? 'Potongan harga spesial khusus untuk pesanan premium Anda.' }}
                                        </div>
                                        <div class="fw-bold {{ $voucher->is_eligible ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">
                                            Min. Belanja: Rp {{ number_format($voucher->min_total, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" 
                                            class="btn fw-bold px-3 py-1.5 {{ $voucher->is_eligible ? 'btn-luxury-primary shadow-sm' : 'btn-outline-secondary disabled' }}"
                                            onclick="useVoucher('{{ $voucher->code }}')" {{ !$voucher->is_eligible ? 'disabled' : '' }} style="border-radius: 8px; font-size: 13px; box-shadow: none;">
                                            Pakai
                                        </button>
                                    </div>
                                </div>
                                @if(!$voucher->is_eligible)
                                    <div class="mt-3 pt-2 border-top text-danger fw-medium" style="font-size: 11px;">
                                        <i class='bx bxs-lock-alt me-1'></i> {{ $voucher->uneligible_reason }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-muted">
                            <i class='bx bx-purchase-tag text-muted opacity-20' style="font-size: 3.5rem;"></i><br>
                            <span class="fw-medium mt-2 d-block small">Belum ada voucher promo yang memenuhi syarat.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = "{{ url('/') }}";

    const toggleServicePlaceholder = (hasData) => {
        const placeholder = document.querySelector('.empty-service-placeholder');
        if(placeholder) {
            placeholder.style.display = hasData ? 'none' : 'block';
        }
    };

    fetch(baseUrl + '/orders/checkout/provinces')
        .then(res => res.json())
        .then(resData => {
            console.log("Respon API Provinsi:", resData);
            if (resData.error) {
                showLuxuryToast('Gagal', 'Masalah API: ' + resData.error, 'error');
                return;
            }

            let provinces = resData.data || resData; 
            let options = '<option value="">-- Pilih Provinsi --</option>';
            
            if (Array.isArray(provinces) && provinces.length > 0) {
                provinces.forEach(p => {
                    options += `<option value="${p.id}|${p.name}">${p.name}</option>`;
                });
            } else {
                options = '<option value="">Data tidak tersedia</option>';
            }
            document.querySelectorAll('.province-select').forEach(s => s.innerHTML = options);
        })
        .catch(err => {
            console.error("Gagal ambil data provinsi:", err);
        });

    document.body.addEventListener('change', function(e) {
        if(e.target.classList.contains('province-select')) {
            let targetId = e.target.getAttribute('data-target');
            let citySelect = document.querySelector(targetId);
            let provId = e.target.value.split('|')[0];

            if(!provId) return;
            citySelect.innerHTML = '<option value="">Loading...</option>';

            fetch(baseUrl + '/orders/checkout/cities?province_id=' + provId)
                .then(res => res.json())
                .then(resData => {
                    console.log("HASIL DATA KOTA:", resData);
                    let cities = resData.data || [];
                    let options = '<option value="">-- Pilih Kota --</option>';
                    cities.forEach(c => {
                        options += `<option value="${c.id}|${c.name}">${c.name}</option>`;
                    });
                    citySelect.innerHTML = options;
                });
        }
    });

    document.querySelectorAll('.courier-code').forEach(input => {
        input.addEventListener('change', function() {
            if(this.checked) toggleServicePlaceholder(true);
        });
    });

    // =========================================================================
    // --- MEMBUAT OPSI LAYANAN ONGKIR CLICKABLE PENUH ---
    document.querySelector('.available-services').addEventListener('click', function(e) {
        let listItem = e.target.closest('.list-group-item');
        if (listItem) {
            let radio = listItem.querySelector('input[type="radio"]');
            if (radio && e.target.tagName !== 'INPUT' && e.target.tagName !== 'LABEL') {
                radio.checked = true;
                radio.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    });
    
    // --- OBAT ANTI HILANG INGATAN (MEMAKSA MAIN.JS BEKERJA) ---
    setTimeout(() => {
        let oldCourier = "{{ old('courier') }}";
        if (oldCourier) {
            let radioBtn = document.querySelector(`.courier-code[value="${oldCourier}"]`);
            if (radioBtn) {
                radioBtn.checked = true;
                toggleServicePlaceholder(true);
                radioBtn.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }, 600);
    // =========================================================================
});

function useVoucher(code) {
    let msg = document.getElementById('voucher-message');
    let btnText = document.getElementById('voucher-btn-text');
    let closeBtn = document.querySelector('#modalPilihVoucher .btn-close');
    if (closeBtn) closeBtn.click();

    btnText.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

    fetch("{{ route('carts.apply_voucher') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ voucher_code: code })
    })
    .then(response => {
        if (!response.ok) throw new Error("Server error");
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('btn-pilih-voucher').disabled = true;
            document.getElementById('btn-remove-voucher').style.setProperty('display', 'flex', 'important');
            btnText.innerHTML = `<i class='bx bxs-check-circle text-success align-middle me-1 fs-5'></i> Voucher Dipakai: <span class="badge bg-dark ms-1">${data.voucher_code}</span>`;

            document.getElementById('voucher-discount-row').style.display = 'flex';
            document.getElementById('discount-amount').innerText = '- Rp ' + data.discount_label;

            let shippingFee = parseInt(document.getElementById('shipping-fee').innerText.replace(/[^0-9]/g, '')) || 0;
            let finalTotal = data.grand_total_raw + shippingFee;
            document.getElementById('grand-total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalTotal);

            if (msg) {
                msg.innerHTML = `<span class="text-success small"><i class='bx bx-check-circle'></i> ${data.message}</span>`;
                setTimeout(() => { msg.innerHTML = ''; }, 3000);
            }
        } else {
            btnText.innerHTML = 'Gunakan Voucher Promo';
            if (msg) msg.innerHTML = `<span class="text-danger small"><i class='bx bx-error-circle'></i> ${data.message}</span>`;
        }
    })
    .catch(error => {
        btnText.innerHTML = 'Gunakan Voucher Promo';
        if (msg) msg.innerHTML = '<span class="text-danger small"><i class="bx bx-error"></i> Terjadi kesalahan server internal.</span>';
    });
}

function removeVoucher() {
    let msg = document.getElementById('voucher-message');
    let btnText = document.getElementById('voucher-btn-text');

    btnText.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Membatalkan...';

    fetch("{{ route('carts.remove_voucher') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('btn-pilih-voucher').disabled = false;
            document.getElementById('btn-remove-voucher').style.setProperty('display', 'none', 'important');
            btnText.innerHTML = 'Gunakan Voucher Promo';

            document.getElementById('voucher-discount-row').style.display = 'none';
            document.getElementById('discount-amount').innerText = '- Rp 0';
            
            let shippingFee = parseInt(document.getElementById('shipping-fee').innerText.replace(/[^0-9]/g, '')) || 0;
            let finalTotal = data.grand_total_raw + shippingFee;
            document.getElementById('grand-total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalTotal);

            if (msg) {
                msg.innerHTML = `<span class="text-secondary small"><i class='bx bx-info-circle'></i> ${data.message}</span>`;
                setTimeout(() => { msg.innerHTML = ''; }, 3000);
            }
        }
    });
}
</script>
@endsection
