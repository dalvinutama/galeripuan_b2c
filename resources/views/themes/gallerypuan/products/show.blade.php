@extends('themes.gallerypuan.layouts.app')

@section('content')

<style>
    .product-detail-title { font-size: 32px; color: #2C1E16; font-weight: 700; margin-bottom: 10px; }
    .active-price-text { font-size: 24px; color: #C5A059; font-weight: 600; }
    .btn-cart-luxury { background-color: #B6867F; color: #FFFFFF; font-weight: 600; text-transform: uppercase; border: none; padding: 10px 20px; transition: 0.3s; }
    .btn-cart-luxury:hover { background-color: #A3736C; color: #FFFFFF; }
    .wishlist-btn-luxury { border: 1px solid #E8E2D9; background: #F9F6F0; transition: 0.3s; }
    .wishlist-btn-luxury:hover { background: #FFFFFF; border-color: #D1A7A0; }
    .text-luxury-brown { color: #3E2723 !important; }
    .text-luxury-gold { color: #C5A059 !important; }
    .color-swatch { border: 1px solid #E8E2D9; background: #F9F6F0; color: #5D4B46; padding: 6px 14px; cursor: pointer; transition: 0.2s; border-radius: 4px; display: inline-block; font-weight: 500; font-size: 14px; }
    .variant-radio:checked + .color-swatch { background-color: #B6867F; color: #FFFFFF; border-color: #B6867F; }
</style>

<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4" style="background-color: #F9F6F0; border-bottom: 1px solid #E8E2D9;">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                <li class="breadcrumb-item"><a href="{{ ('/') }}" style="color: #5D4B46; text-decoration: none;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('products') }}" style="color: #5D4B46; text-decoration: none;">Produk</a></li>
                <li class="breadcrumb-item active text-luxury-brown d-none d-md-inline-block" aria-current="page" style="font-weight: 600; color: #2C1E16 !important;">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="product-images" class="carousel slide" data-ride="carousel">
                    <!-- slides -->
                    <div class="carousel-inner">
                        @forelse ($product->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}"> 
                                <img src="{{ shop_product_image($image) }}" alt="{{ $product->name }}" class="img-fluid w-100 rounded"> 
                            </div>
                        @empty
                            <div class="carousel-item active"> 
                                <img src="{{ asset('themes/gallerypuan/assets/img/product_single_01.jpg') }}" alt="Default" class="img-fluid w-100 rounded"> 
                            </div>
                        @endforelse
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#product-images" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Sebelumnya</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#product-images" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Berikutnya</span>
                    </button>

                    <ol class="carousel-indicators list-inline mt-3">
                        @forelse ($product->images as $key => $image)
                            <li class="list-inline-item {{ $key == 0 ? 'active' : '' }}"> 
                                <a id="carousel-selector-{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" data-bs-slide-to="{{ $key }}" data-bs-target="#product-images"> 
                                    <img src="{{ shop_product_image($image) }}" class="img-fluid" width="80"> 
                                </a> 
                            </li>
                        @empty
                            <li class="list-inline-item active"> 
                                <a id="carousel-selector-0" class="active" data-bs-slide-to="0" data-bs-target="#product-images"> 
                                    <img src="{{ asset('themes/gallerypuan/assets/img/product_single_01.jpg') }}" class="img-fluid" width="80"> 
                                </a> 
                            </li>
                        @endforelse
                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-detail mt-6 mt-md-0">
                    <h1 class="mb-1 product-detail-title">{{ $product->name }}</h1>
                    
                    @php
                        $productIds = [$product->id];
                        if ($product->variants && $product->variants->count() > 0) {
                            $productIds = array_merge($productIds, $product->variants->pluck('id')->toArray());
                        }
                        $semuaUlasan = \Modules\Shop\Entities\Review::whereIn('product_id', $productIds)
                                            ->where('status', 'approved')
                                            ->latest()
                                            ->get();
                        $rataRata = $semuaUlasan->avg('rating') ?: 0;
                        $jumlahUlasan = $semuaUlasan->count();
                    @endphp

                    <div class="mb-3 rating d-flex align-items-center">
                        <small class="text-luxury-gold fs-6">
                            @for($i=1; $i<=5; $i++)
                                <i class="bx {{ $i <= round($rataRata) ? 'bxs-star' : 'bx-star' }}"></i>
                            @endfor
                        </small>
                        <a href="#nav-product-reviews" class="ms-2 text-decoration-none" style="color: #5D4B46; font-size: 14px;">({{ $jumlahUlasan }} Ulasan)</a>
                    </div>
                    <div class="price">
                        @if ($product->hasSalePrice && $product->discount_percent > 0)
                            <span class="active-price-text" id="display-price">Rp {{ $product->sale_price_label }}</span>
                            <span class="text-decoration-line-through ms-1" style="color: #5D4B46;">Rp {{ $product->price_label }}</span>
                            <span><small class="discount-percent ms-2 px-2 py-1 rounded" style="background-color: #F9F6F0; color: #B6867F; font-weight: 600; font-size: 12px;">Diskon {{ $product->discount_percent }}%</small></span>
                        @else
                            <span class="active-price-text" id="display-price">Rp {{ $product->price_label }}</span>
                        @endif
                    </div>
                    <hr class="my-6" style="border-color: #E8E2D9;">

                    @if(strtoupper($product->type) == 'CONFIGURABLE' && $product->variants->count() > 0)
                    <div class="mb-4">
                        <label class="form-label text-luxury-brown fw-bold mb-2">Pilih Varian (Warna):</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->variants as $variant)
                            <label class="color-swatch-label m-0">
                                <input type="radio" name="variant_id_dummy" value="{{ $variant->id }}" class="d-none variant-radio" data-stock="{{ $variant->inventory ? $variant->inventory->qty : 0 }}" data-price="{{ $variant->price_label }}" data-status="{{ $variant->stock_status_label }}">
                                <span class="color-swatch">{{ $variant->attributes['color'] ?? 'Warna' }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="product-select mt-3 row justify-content-start g-2 align-items-center">
                        @include ('themes.gallerypuan.shared.flash')
                        {{ html()->form('post', route('carts.store'))->class('add-to-cart-form')->id('form-add-to-cart')->open() }}
                        <input type="hidden" name="product_id" id="input-product-id" value="{{ strtoupper($product->type) == 'CONFIGURABLE' ? '' : $product->id }}"/>
                        <div class="row">
                            <div class="col-md-2 col-3">
                                <input type="number" name="qty" value="1" class="form-control text-center text-luxury-brown" min="1" style="border-color: #E8E2D9;" />
                            </div>
                            <div class="col-xxl-4 col-lg-4 col-md-5 col-6 d-grid px-1">
                                <button type="button" id="btn-submit-cart" class="btn btn-cart-luxury" style="font-size: 14px;"><i class="bx bx-cart-alt"></i> Tambah</button>
                            </div>
                            <div class="col-md-4 col-3">
                                @php
                                    $isWishlisted = false;
                                    if(auth()->check()) {
                                        $isWishlisted = \Modules\Shop\Entities\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                                    }
                                @endphp
                                
                                <button type="button" class="btn wishlist-btn-luxury wishlist-btn" data-product="{{ $product->id }}" data-bs-toggle="tooltip" aria-label="Wishlist">
                                    <i class="bx {{ $isWishlisted ? 'bxs-heart text-danger' : 'bx-heart' }} fs-5" style="color: {{ $isWishlisted ? '' : '#5D4B46' }};"></i>
                                </button>
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-warning w-100 mb-3" style="border-color: #A47E1B; color: #A47E1B; font-weight: 500;" 
                            onclick="panggilChat()">
                            <i class='bx bx-message-square-dots me-2'></i> Tanya Admin tentang produk ini
                        </button>
                    </div>
                    <hr class="my-6" style="border-color: #E8E2D9;">
                    <div class="product-info">
                        <table class="table table-borderless mb-0 text-luxury-brown">
                            <tbody>
                                <tr>
                                    <td style="color: #5D4B46;">SKU:</td>
                                    <td class="fw-bold">{{ $product->sku}}</td>
                                </tr>
                                <tr>
                                    <td style="color: #5D4B46;">Ketersediaan:</td>
                                    <td class="fw-bold text-luxury-gold" id="display-stock">{{ $product->stock_status_label }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="text-luxury-brown" style="font-size: 15px; line-height: 1.6;">
                        <p>{!! $product->excerpt !!}</p>
                    </div>
                    <hr class="my-6" style="border-color: #E8E2D9;">
                    <div class="product-share">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#" class="text-luxury-brown fs-5" onmouseover="this.style.color='#C5A059'" onmouseout="this.style.color='#3E2723'"><i class="bx bxl-facebook-circle"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-luxury-brown fs-5" onmouseover="this.style.color='#C5A059'" onmouseout="this.style.color='#3E2723'"><i class="bx bxl-pinterest"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-luxury-brown fs-5" onmouseover="this.style.color='#C5A059'" onmouseout="this.style.color='#3E2723'"><i class="bx bxl-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-description pt-5">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active text-luxury-brown" id="nav-product-details-tab" data-bs-toggle="tab" data-bs-target="#nav-product-details" type="button" role="tab" aria-controls="nav-product-details" aria-selected="true" style="font-weight: 600;">Deskripsi Produk</button>
                        <button class="nav-link text-luxury-brown" id="nav-product-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-product-reviews" type="button" role="tab" aria-controls="nav-product-reviews" aria-selected="false">Ulasan</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active p-3" id="nav-product-details" role="tabpanel" aria-labelledby="nav-product-details-tab">
                        <div class="my-8 text-luxury-brown" style="line-height: 1.8; font-size: 15px;">
                        <p>{!! $product->body !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="nav-product-reviews" role="tabpanel" aria-labelledby="nav-product-reviews-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-4 text-luxury-brown">Ulasan Pelanggan</h4>
                                
                                @if($jumlahUlasan > 0)
                                    <div class="d-flex align-items-center mb-5 p-4 rounded" style="background-color: #F9F6F0; border: 1px dashed #B6867F;">
                                        <h1 class="fw-bold me-3 mb-0 text-luxury-gold" style="font-size: 3.5rem;">{{ number_format($rataRata, 1) }}<span style="font-size: 1.5rem; color:#5D4B46;">/5</span></h1>
                                        <div>
                                            <div class="text-luxury-gold" style="font-size: 1.5rem;">
                                                @for($i=1; $i<=5; $i++)
                                                    <i class="bx {{ $i <= round($rataRata) ? 'bxs-star' : 'bx-star' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-luxury-brown fw-bold">Dari total {{ $jumlahUlasan }} ulasan terverifikasi</small>
                                        </div>
                                    </div>

                                    <div class="review-list">
                                        @foreach($semuaUlasan as $ulasan)
                                            <div class="d-flex mb-4 pb-4 border-bottom" style="border-color: #E8E2D9 !important;">
                                                <div class="me-3">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 50px; height: 50px; font-size: 20px; font-weight: bold; background-color: #D1A7A0;">
                                                        {{ strtoupper(substr($ulasan->user->name ?? 'A', 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6 class="fw-bold mb-0 text-luxury-brown">{{ $ulasan->user->name ?? 'Pelanggan' }}</h6>
                                                        <small style="color: #5D4B46;">{{ \Carbon\Carbon::parse($ulasan->created_at)->format('d M Y') }}</small>
                                                    </div>
                                                    <div class="text-luxury-gold small mb-2">
                                                        @for($i=1; $i<=5; $i++)
                                                            <i class="bx {{ $i <= $ulasan->rating ? 'bxs-star' : 'bx-star' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <p class="mb-0 text-luxury-brown" style="font-size: 14px;">{{ $ulasan->comment ?? 'Tidak ada komentar tertulis.' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5 rounded" style="background-color: #F9F6F0;">
                                        <i class="bx bx-message-square-dots mb-3" style="font-size: 3rem; color: #B6867F;"></i>
                                        <h6 class="fw-bold text-luxury-brown">Belum ada ulasan untuk produk ini</h6>
                                        <p style="color: #5D4B46; font-size: 14px; margin-bottom: 0;">Jadilah yang pertama memiliki produk ini dan bagikan pengalamanmu.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const variantRadios = document.querySelectorAll('.variant-radio');
        const inputProductId = document.getElementById('input-product-id');
        const displayPrice = document.getElementById('display-price');
        const displayStock = document.getElementById('display-stock');
        const formAddToCart = document.getElementById('form-add-to-cart');
        const btnSubmitCart = document.getElementById('btn-submit-cart');

        variantRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                inputProductId.value = this.value;
                if(this.dataset.price) {
                    displayPrice.innerText = 'Rp ' + this.dataset.price;
                }
                if(displayStock) {
                    let stock = parseInt(this.dataset.stock);
                    displayStock.innerText = stock > 0 ? 'Tersedia (' + stock + ')' : 'Habis';
                }
            });
        });

        if(btnSubmitCart && formAddToCart) {
            btnSubmitCart.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (variantRadios.length > 0 && !document.querySelector('.variant-radio:checked')) {
                    showLuxuryToast('Perhatian', 'Silakan pilih varian/warna terlebih dahulu.', 'warning');
                    return false;
                }
                
                // Submit form directly if validated
                formAddToCart.submit();
            });
        }
    });

    function panggilChat() {
        let namaProduk = "{{ addslashes($product->name) }}";
        
        // Mengambil foto produk pertama yang ada di halaman ini
        let gambarProduk = "{{ $product->images->count() > 0 ? shop_product_image($product->images->first()) : asset('themes/gallerypuan/assets/img/product_single_01.jpg') }}";
        
        Livewire.dispatch('buka-chat', { 
            pesan: "Halo Admin, apakah produk *" + namaProduk + "* ini masih ready?",
            gambar: gambarProduk 
        });
    }
</script>

@endsection