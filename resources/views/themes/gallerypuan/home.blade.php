@extends('themes.gallerypuan.layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap');

    /* FONDASI HALAMAN */
    body {
        background-color: #FFFDFB; 
        color: #5C4D4A;
        font-family: 'Poppins', sans-serif;
        margin: 0; padding: 0; overflow-x: hidden;
    }
    
    h1, h2, h3, h4, .font-serif {
        font-family: 'Playfair Display', serif;
    }

    /* BLOK WARNA */
    .section-white {
        background-color: #FFFFFF;
        padding: 80px 0 100px 0; 
        position: relative;
        z-index: 1;
        margin-top: -2px;
    }
    .section-cream {
        background-color: #F9F6F0;
        padding: 80px 0 100px 0;
    }

    /* HERO SECTION */
    .hero-section {
        position: relative;
        width: 100%;
        /* FIX GAP: Memastikan tinggi hero pas dan tidak meninggalkan ruang sisa */
        min-height: calc(100vh - 80px); 
        display: flex;
        align-items: center;
        @php
            $heroImage = \App\Models\Setting::getValue('home_hero_image', 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?q=80&w=1974&auto=format&fit=crop');
        @endphp
        background: url('{{ Str::startsWith($heroImage, "http") ? $heroImage : asset($heroImage) }}') center/cover no-repeat; 
    }

    .hero-gradient {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(90deg, rgba(92, 77, 74, 0.75) 0%, rgba(92, 77, 74, 0.2) 60%, rgba(255, 253, 251, 0) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 60%; 
        padding-left: 8%;
        color: #FFFDFB;
    }

    .hero-title {
        font-size: clamp(3rem, 5vw, 5.5rem);
        font-weight: 600;
        line-height: 1.1;
        letter-spacing: 1.5px;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .hero-subtitle {
        font-size: 1.1rem;
        font-weight: 300;
        max-width: 500px;
        margin-bottom: 2.5rem;
        color: #F9F6F0;
        line-height: 1.8;
        letter-spacing: 0.5px;
    }

    .btn-aesthetic-solid {
        background-color: #D1A7A0;
        color: #FFFFFF;
        padding: 14px 38px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        letter-spacing: 1px;
        transition: all 0.4s ease;
        border: 1px solid #D1A7A0;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
    }
    .btn-aesthetic-solid:hover { 
        background-color: #BD918B; 
        color: #FFFFFF; 
        border-color: #BD918B;
        transform: translateY(-2px); 
        box-shadow: 0 10px 20px rgba(209, 167, 160, 0.2); 
    }

    .btn-aesthetic-outline {
        border: 1px solid #FFFDFB;
        color: #FFFDFB;
        padding: 14px 38px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        letter-spacing: 1px;
        transition: all 0.4s ease;
        margin-left: 15px;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
    }
    .btn-aesthetic-outline:hover { 
        background-color: #FFFDFB; 
        color: #5C4D4A; 
        transform: translateY(-2px); 
    }

    @media (max-width: 768px) {
        .hero-content {
            width: 100%;
            padding: 0 5%;
            text-align: center;
        }
        .hero-title {
            font-size: 2.5rem;
        }
        .btn-aesthetic-solid, .btn-aesthetic-outline {
            display: block;
            width: 100%;
            margin: 10px 0;
            text-align: center;
        }
        .btn-aesthetic-outline { margin-left: 0; }
        .hero-gradient {
            background: linear-gradient(180deg, rgba(92, 77, 74, 0.4) 0%, rgba(92, 77, 74, 0.8) 100%);
        }
        .section-white .col-md-6.p-5 {
            padding: 30px 20px !important;
        }
        .section-white .col-md-6.p-0 {
            height: 300px !important;
        }
    }

    /* PRODUCT CAROUSEL */
    .slider-container {
        position: relative;
        width: 100%;
        padding: 10px 0 20px 0;
    }

    .product-slider {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 24px;
        padding-bottom: 20px;
        scrollbar-width: none; 
    }
    .product-slider::-webkit-scrollbar { display: none; }

    .slider-btn {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        background: #FFFFFF;
        border: 1px solid #E8E2D9;
        box-shadow: 0 8px 25px rgba(92, 77, 74, 0.08);
        color: #5C4D4A;
        width: 50px; height: 50px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        z-index: 10;
        opacity: 0.9;
        transition: all 0.4s ease;
        font-size: 24px;
    }
    .slider-btn:hover { 
        opacity: 1; 
        background: #C5A059; 
        color: #FFFFFF; 
        border-color: #C5A059;
        transform: translateY(-50%) scale(1.05);
    }
    .slider-prev { left: -20px; }
    .slider-next { right: -20px; }

    /* KARTU PRODUK PREMIUM */
    .product-card-clean {
        min-width: 280px;
        max-width: 280px;
        display: flex;
        flex-direction: column;
        background-color: transparent;
        border: none;
        padding: 0;
        transition: transform 0.4s ease;
    }
    
    .product-card-clean:hover {
        transform: translateY(-8px);
    }

    .product-image-box {
        background-color: #F9F6F0; 
        border-radius: 8px;
        aspect-ratio: 3/4;
        overflow: hidden;
        margin-bottom: 20px;
        position: relative;
    }
    .product-image-box img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .product-image-box:hover img { transform: scale(1.05); }

    .product-info {
        text-align: center;
        padding: 0 10px;
    }
    .product-info h3 {
        font-size: 16px; font-weight: 500; color: #5C4D4A; margin-bottom: 8px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        letter-spacing: 0.5px;
    }
    .product-info p { 
        font-size: 15px; color: #C5A059; font-weight: 600; margin-bottom: 16px; 
    }
    
    .add-cart-text { 
        font-size: 12px; color: #5C4D4A; text-decoration: none; font-weight: 600; 
        display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; 
        background: transparent; border: 1px solid #5C4D4A; cursor: pointer; 
        padding: 10px 20px; border-radius: 4px; width: 100%; justify-content: center;
        text-transform: uppercase; letter-spacing: 1px;
    }
    .add-cart-text:hover { 
        background: #5C4D4A; color: #FFFFFF; 
    }

    /* KELAS ANIMASI JS (Efek Fade & Slide) */
    .reveal-up {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
    }
    .reveal-up.active {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<section class="hero-section">
    <div class="hero-gradient"></div>
    <div class="hero-content reveal-up">
        <h1 class="hero-title font-serif">{!! \App\Models\Setting::getValue('home_hero_title', 'Koleksi Hijab<br>Elegan & Nyaman') !!}</h1>
        <p class="hero-subtitle">
            {{ \App\Models\Setting::getValue('home_hero_subtitle', 'Didesain dengan material premium yang sejuk. Sempurnakan penampilan harian dan momen spesialmu dengan koleksi warna pastel eksklusif dari Gallery Puan.') }}
        </p>
        <div>
            <a href="{{ route('products.index') }}" class="btn-aesthetic-solid">Belanja Sekarang</a>
            <a href="#kategori" class="btn-aesthetic-outline">Lihat Koleksi</a>
        </div>
    </div>
</section>

<section class="section-white">
    <div class="container reveal-up">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="font-serif fw-bold mb-2" style="font-size: 32px; color: #5C4D4A; letter-spacing: 1px;">Koleksi Terbaru</h2>
                <p style="color: #A3918E; font-size: 15px; margin-bottom: 0; font-weight: 300;">Eksplorasi pilihan hijab terfavorit minggu ini.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-decoration-none" style="color: #C5A059; font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Lihat Semua <i class="bx bx-right-arrow-alt"></i></a>
        </div>
        
        <div class="slider-container">
            <div class="slider-btn slider-prev" onclick="scrollSlider(-300, 'productSlider')"><i class="bx bx-chevron-left"></i></div>
            <div class="slider-btn slider-next" onclick="scrollSlider(300, 'productSlider')"><i class="bx bx-chevron-right"></i></div>
            
            <div class="product-slider" id="productSlider">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                    <div class="product-card-clean">
                        <div class="product-image-box">
                            <a href="{{ shop_product_link($product) }}">
                                <img src="{{ shop_product_image($product->image, 'img-medium') }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="product-info">
                            <h3><a href="{{ shop_product_link($product) }}" class="text-decoration-none" style="color: inherit;">{{ $product->name }}</a></h3>
                            <p>Rp {{ $product->price_label }}</p>

                            {{ html()->form('post', route('carts.store'))->class('m-0')->open() }}
                                <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                                <input type="hidden" name="qty" value="1"/>
                                @if(strtoupper($product->type) == 'CONFIGURABLE')
                                    @php
                                        $qvVariants = $product->variants->map(function($v) {
                                            return [
                                                'id' => $v->id,
                                                'color' => $v->attributes['color'] ?? 'Warna',
                                                'stock' => $v->inventory->qty ?? 0
                                            ];
                                        });
                                    @endphp
                                    <button type="button" onclick="openQuickView(event, '{{ addslashes($product->name) }}', this.getAttribute('data-variants'))" data-variants="{{ json_encode($qvVariants) }}" class="add-cart-text">Tambah Keranjang <i class="bx bx-cart-alt"></i></button>
                                @else
                                    <button type="submit" class="add-cart-text">Tambah Keranjang <i class="bx bx-cart-alt"></i></button>
                                @endif
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted w-100 text-center py-5">Belum ada produk yang ditambahkan ke database.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section id="kategori" class="section-cream">
    <div class="container reveal-up">
        <div class="d-flex justify-content-center align-items-center mb-5">
            <div class="text-center">
                <h2 class="font-serif fw-bold mb-2" style="font-size: 32px; color: #5C4D4A; letter-spacing: 1px;">Kategori Pilihan</h2>
                <p style="color: #A3918E; font-size: 15px; margin-bottom: 0; font-weight: 300;">Temukan koleksi berdasarkan gayamu.</p>
            </div>
        </div>

        <div class="slider-container">
            <div class="slider-btn slider-prev" onclick="scrollSlider(-300, 'categorySlider')"><i class="bx bx-chevron-left"></i></div>
            <div class="slider-btn slider-next" onclick="scrollSlider(300, 'categorySlider')"><i class="bx bx-chevron-right"></i></div>
            
            <div class="product-slider" id="categorySlider">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                        @if(isset($category->products) && $category->products->count() > 0)
                            <div class="product-card-clean" style="min-width: 250px; max-width: 250px;">
                                <a href="{{ shop_category_link($category) }}" class="d-block position-relative" style="border-radius: 8px; overflow: hidden; aspect-ratio: 9/12; transition: transform 0.4s ease; box-shadow: 0 10px 30px rgba(92, 77, 74, 0.08);">
                                    
                                    @php
                                        $gambarKategori = shop_product_image($category->products->first()->image, 'img-medium');
                                    @endphp
                                    
                                    <img src="{{ $gambarKategori }}" style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.8); transition: all 0.6s ease;">
                                    
                                    <div class="position-absolute w-100 h-100 top-0 d-flex align-items-center justify-content-center" style="background: linear-gradient(to top, rgba(92, 77, 74, 0.4), transparent);">
                                        <span class="bg-white px-4 py-2" style="font-size: 12px; font-weight: 600; letter-spacing: 2px; color: #5C4D4A; text-transform: uppercase; border-radius: 2px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <p class="text-center text-muted w-100">Belum ada kategori dalam database.</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     SECTION: REKOMENDASI PRODUK YANG DIPERSONALISASI
     Data: $recommendedProducts — dikirim dari HomeController
     ================================================================ --}}
@if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
<section class="section-cream reveal-up" id="rekomendasi">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                {{-- Heading dinamis: personal jika user login & punya riwayat, umum jika fallback --}}
                @auth
                    <h2 class="font-serif fw-bold mb-2" style="font-size: 32px; color: #5C4D4A; letter-spacing: 1px;">
                        Pilihan Untuk Anda
                        <span style="font-size: 20px;">✨</span>
                    </h2>
                    <p style="color: #A3918E; font-size: 15px; margin-bottom: 0; font-weight: 300;">
                        Dikurasi dari kategori favoritmu. Belum pernah kamu miliki.
                    </p>
                @else
                    <h2 class="font-serif fw-bold mb-2" style="font-size: 32px; color: #5C4D4A; letter-spacing: 1px;">
                        Produk Pilihan
                    </h2>
                    <p style="color: #A3918E; font-size: 15px; margin-bottom: 0; font-weight: 300;">
                        Produk terbaru yang siap menemani penampilanmu.
                    </p>
                @endauth
            </div>
            <a href="{{ route('products.index') }}" class="text-decoration-none"
               style="color: #C5A059; font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
               Lihat Semua <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>

        <div class="slider-container">
            <div class="slider-btn slider-prev" onclick="scrollSlider(-300, 'recommendedSlider')">
                <i class="bx bx-chevron-left"></i>
            </div>
            <div class="slider-btn slider-next" onclick="scrollSlider(300, 'recommendedSlider')">
                <i class="bx bx-chevron-right"></i>
            </div>

            <div class="product-slider" id="recommendedSlider">
                @foreach($recommendedProducts as $product)
                <div class="product-card-clean">
                    {{-- Badge Diskon --}}
                    <div class="product-image-box" style="position: relative;">
                        @if($product->hasSalePrice && $product->discount_percent > 0)
                            <div class="position-absolute" style="top: 10px; right: 10px; background-color: #D32F2F; color: #FFFFFF; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px; z-index: 10; letter-spacing: 0.5px;">
                                -{{ $product->discount_percent }}%
                            </div>
                        @endif
                        <a href="{{ shop_product_link($product) }}">
                            <img src="{{ shop_product_image($product->image, 'img-medium') }}"
                                 alt="{{ $product->name }}">
                        </a>
                    </div>

                    <div class="product-info">
                        <h3>
                            <a href="{{ shop_product_link($product) }}" class="text-decoration-none" style="color: inherit;">
                                {{ $product->name }}
                            </a>
                        </h3>

                        {{-- Harga: tampilkan sale_price jika ada --}}
                        @if($product->hasSalePrice && $product->discount_percent > 0)
                            <p style="margin-bottom: 4px;">
                                <span style="color: #D32F2F;">Rp {{ $product->sale_price_label }}</span>
                            </p>
                            <p style="font-size: 12px; color: #A3918E; text-decoration: line-through; margin-bottom: 16px; font-weight: 400;">
                                Rp {{ $product->price_label }}
                            </p>
                        @else
                            <p>Rp {{ $product->price_label }}</p>
                        @endif

                        {{ html()->form('post', route('carts.store'))->class('m-0')->open() }}
                            <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                            <input type="hidden" name="qty" value="1"/>

                            @if(strtoupper($product->type) == 'CONFIGURABLE')
                                @php
                                    $recVariants = $product->variants->map(function($v) {
                                        return [
                                            'id'    => $v->id,
                                            'color' => $v->attributes['color'] ?? 'Warna',
                                            'stock' => $v->inventory->qty ?? 0,
                                        ];
                                    });
                                @endphp
                                <button type="button"
                                    onclick="openQuickView(event, '{{ addslashes($product->name) }}', this.getAttribute('data-variants'))"
                                    data-variants="{{ json_encode($recVariants) }}"
                                    class="add-cart-text">
                                    Tambah Keranjang <i class="bx bx-cart-alt"></i>
                                </button>
                            @else
                                <button type="submit" class="add-cart-text">
                                    Tambah Keranjang <i class="bx bx-cart-alt"></i>
                                </button>
                            @endif
                        {{ html()->form()->close() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="section-white">
    <div class="container reveal-up">
        <div class="row align-items-center" style="background-color: #F9F6F0; border-radius: 12px; overflow: hidden; box-shadow: 0 15px 40px rgba(92, 77, 74, 0.08);">
            <div class="col-md-6 p-5 px-lg-5 py-lg-0 text-center text-md-start" style="padding: 60px !important;">
                <span class="badge mb-4" style="background-color: #D1A7A0; font-weight: 500; padding: 8px 20px; letter-spacing: 1.5px; text-transform: uppercase; font-size: 11px;">{{ \App\Models\Setting::getValue('home_promo_badge', 'Promo Terbatas') }}</span>
                <h2 class="font-serif fw-bold mb-3" style="font-size: 40px; color: #5C4D4A; line-height: 1.2;">{{ \App\Models\Setting::getValue('home_promo_title', 'Exclusive Bundle Raya') }}</h2>
                <p class="mb-5" style="color: #A3918E; font-size: 16px; line-height: 1.8; font-weight: 300;">{{ \App\Models\Setting::getValue('home_promo_subtitle', 'Dapatkan harga spesial untuk pembelian paket bundle hijab pastel series. Pilihan sempurna untuk hadiah orang terkasih atau melengkapi koleksi harian Anda.') }}</p>
                <a href="{{ route('products.index', ['promo' => 'true']) }}" class="btn-aesthetic-solid">Ambil Promo</a>
            </div>
            <div class="col-md-6 p-0" style="height: 450px;">
                @php
                    $promoImage = \App\Models\Setting::getValue('home_promo_image', 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop');
                @endphp
                <img src="{{ Str::startsWith($promoImage, 'http') ? $promoImage : asset($promoImage) }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<script>
    // JS untuk Navigasi Slider
    function scrollSlider(amount, sliderId) {
        const slider = document.getElementById(sliderId);
        if(slider) {
            slider.scrollBy({ left: amount, behavior: 'smooth' });
        }
    }

    // JS Animasi "Sultan" (Scroll Reveal)
    document.addEventListener("DOMContentLoaded", function() {
        // Memicu animasi pertama kali saat halaman dimuat
        setTimeout(() => {
            document.querySelector('.hero-content').classList.add('active');
        }, 100);

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15 // Animasi mulai saat elemen terlihat 15%
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target); // Hanya animasi sekali
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-up').forEach((el) => {
            observer.observe(el);
        });
    });
</script>

@endsection