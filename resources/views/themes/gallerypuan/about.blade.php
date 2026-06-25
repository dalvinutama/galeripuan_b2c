@extends('themes.gallerypuan.layouts.app')

@section('content')

<style>
    /* Styling khusus Halaman Tentang Kami */
    .about-hero {
        background-color: #F9F6F0;
        padding: 80px 0;
        text-align: center;
        border-bottom: 1px solid #E8E2D9;
    }
    .about-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        color: #2C1E16;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .about-hero-subtitle {
        font-size: 18px;
        color: #3E2723;
        max-width: 600px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }
    .btn-luxury-primary {
        background-color: #B6867F;
        color: #FFFFFF;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-luxury-primary:hover {
        background-color: #A3736C;
        color: #FFFFFF;
        box-shadow: 0 4px 15px rgba(163, 115, 108, 0.3);
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        color: #2C1E16;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
    }
    .text-luxury {
        color: #3E2723;
        line-height: 1.8;
        font-size: 16px;
    }
    
    .visi-misi-card {
        background-color: #FFFFFF;
        border: 1px solid #E8E2D9;
        border-radius: 12px;
        padding: 40px;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }
    .visi-misi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        border-color: #D1A7A0;
    }
    .visi-misi-icon {
        font-size: 40px;
        color: #C5A059;
        margin-bottom: 20px;
    }
    
    .feature-card {
        background-color: #F9F6F0;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        height: 100%;
        transition: 0.3s;
        border: 1px dashed transparent;
    }
    .feature-card:hover {
        border-color: #D1A7A0;
        background-color: #FFFFFF;
    }
    .feature-icon {
        font-size: 36px;
        color: #D1A7A0;
        margin-bottom: 15px;
    }
    .feature-title {
        font-weight: 700;
        color: #2C1E16;
        margin-bottom: 10px;
        font-size: 16px;
    }
    
    .gallery-item {
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .gallery-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-item:hover .gallery-img {
        transform: scale(1.05);
    }
    .gallery-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(44, 30, 22, 0.6);
        opacity: 0;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-overlay i {
        color: #FFFFFF;
        font-size: 32px;
    }

    .testimonial-card {
        background-color: #F9F6F0;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        border: 1px solid #E8E2D9;
        margin-bottom: 20px;
    }
    .testimonial-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #FFFDFB;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin: -70px auto 20px;
    }
    .testimonial-stars {
        color: #C5A059;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .cta-banner {
        background: linear-gradient(135deg, #F9F6F0, #FFFDFB);
        padding: 60px 0;
        text-align: center;
        border-top: 1px solid #E8E2D9;
        border-bottom: 1px solid #E8E2D9;
        margin-top: 60px;
    }
</style>

<!-- 1. Hero Section -->
<section class="about-hero">
    <div class="container">
        <h1 class="about-hero-title">{{ \App\Models\Setting::getValue('about_hero_title', 'Kecantikan dalam Balutan Kesantunan') }}</h1>
        <p class="about-hero-subtitle">{{ \App\Models\Setting::getValue('about_hero_subtitle', 'Hadir untuk menemani setiap langkah muslimah tampil anggun, nyaman, dan percaya diri dalam segala suasana.') }}</p>
        <a href="{{ url('products') }}" class="btn-luxury-primary">Belanja Sekarang</a>
    </div>
</section>

<!-- 2. Cerita Brand -->
<section class="py-5" style="background-color: #FFFDFB;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                @php
                    $aboutStoryImage = \App\Models\Setting::getValue('about_story_image', 'themes/gallerypuan/assets/img/product_single_01.jpg');
                @endphp
                <img src="{{ Str::startsWith($aboutStoryImage, 'http') ? $aboutStoryImage : asset($aboutStoryImage) }}" alt="Tentang Kami" class="img-fluid rounded" style="box-shadow: 0 15px 40px rgba(0,0,0,0.08);">
            </div>
            <div class="col-md-6 ps-md-5">
                <h2 class="section-title text-start mb-4">{{ \App\Models\Setting::getValue('about_story_title', 'Cerita Kami') }}</h2>
                @php
                    $defaultDescription = '<p class="text-luxury">Gallery Puan lahir dari sebuah keinginan sederhana: menghadirkan koleksi hijab yang tidak hanya memenuhi syariat, tetapi juga menonjolkan estetika modern dan elegan. Kami percaya bahwa setiap wanita berhak merasa cantik dan istimewa.</p><p class="text-luxury">Oleh karena itu, kami selalu mengedepankan kualitas material premium, jahitan yang rapi, serta mengikuti perkembangan tren fashion muslimah masa kini. Kepuasan Anda adalah prioritas kami dalam merangkai keanggunan sejati.</p>';
                    $aboutDescription = \App\Models\Setting::getValue('about_story_description', $defaultDescription);
                @endphp
                <div class="about-description-content">
                    {!! nl2br($aboutDescription) !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Visi dan Misi -->
<section class="py-5" style="background-color: #F9F6F0;">
    <div class="container py-4">
        <h2 class="section-title">Visi & Misi</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="visi-misi-card text-center">
                    <i class='bx bx-bullseye visi-misi-icon'></i>
                    <h4 class="fw-bold mb-3" style="color: #2C1E16;">Visi</h4>
                    <p class="text-luxury mb-0">Menjadi brand hijab terpercaya yang menghadirkan fashion muslimah modern, elegan, dan berkualitas untuk wanita Indonesia.</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="visi-misi-card text-center">
                    <i class='bx bx-flag visi-misi-icon'></i>
                    <h4 class="fw-bold mb-3" style="color: #2C1E16;">Misi</h4>
                    <ul class="text-start text-luxury mb-0" style="list-style-type: disc; padding-left: 20px;">
                        <li>Menyediakan produk hijab berkualitas premium.</li>
                        <li>Menghadirkan desain hijab modern yang kekinian.</li>
                        <li>Memberikan pengalaman belanja online terbaik.</li>
                        <li>Menjaga kepuasan dan kepercayaan pelanggan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Kenapa Memilih Kami -->
<section class="py-5" style="background-color: #FFFDFB;">
    <div class="container py-4">
        <h2 class="section-title">Kenapa Memilih Kami?</h2>
        <div class="row g-4">
            <div class="col-6 col-md-4 text-center">
                <div class="feature-card">
                    <i class='bx bx-diamond feature-icon'></i>
                    <h5 class="feature-title">Bahan Premium</h5>
                    <p class="text-muted small mb-0">Menggunakan material terbaik yang nyaman dan lembut dipakai.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center">
                <div class="feature-card">
                    <i class='bx bx-palette feature-icon'></i>
                    <h5 class="feature-title">Desain Kekinian</h5>
                    <p class="text-muted small mb-0">Warna dan model yang selalu up-to-date dengan tren fashion.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center">
                <div class="feature-card">
                    <i class='bx bx-purchase-tag-alt feature-icon'></i>
                    <h5 class="feature-title">Harga Terbaik</h5>
                    <p class="text-muted small mb-0">Kualitas butik mewah dengan harga yang bersahabat.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center">
                <div class="feature-card">
                    <i class='bx bx-package feature-icon'></i>
                    <h5 class="feature-title">Pengiriman Cepat</h5>
                    <p class="text-muted small mb-0">Proses pesanan dan pengemasan yang aman dan cepat.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center">
                <div class="feature-card">
                    <i class='bx bx-smile feature-icon'></i>
                    <h5 class="feature-title">Pelayanan Ramah</h5>
                    <p class="text-muted small mb-0">Customer service kami siap membantu Anda kapan saja.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center">
                <div class="feature-card">
                    <i class='bx bx-check-shield feature-icon'></i>
                    <h5 class="feature-title">Kualitas Terjamin</h5>
                    <p class="text-muted small mb-0">Melewati proses quality control yang ketat sebelum dikirim.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Galeri Brand -->
<section class="py-5" style="background-color: #FFFDFB;">
    <div class="container py-2">
        <h2 class="section-title">Galeri Estetik</h2>
        <div class="row g-3">
            @php
                $aboutGalleryImages = \App\Models\SettingImage::where('setting_key', 'about_gallery')->orderBy('created_at', 'desc')->get();
            @endphp
            
            @if($aboutGalleryImages->count() > 0)
                @foreach($aboutGalleryImages as $galleryImage)
                <div class="col-md-3 col-6">
                    <div class="gallery-item">
                        <img src="{{ asset($galleryImage->image_path) }}" class="gallery-img" alt="Gallery">
                        <div class="gallery-overlay"><i class='bx bxl-instagram'></i></div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-md-3 col-6">
                    <div class="gallery-item">
                        <img src="{{ asset('themes/gallerypuan/assets/img/product_single_01.jpg') }}" class="gallery-img" alt="Gallery 1">
                        <div class="gallery-overlay"><i class='bx bxl-instagram'></i></div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="gallery-item">
                        <img src="{{ asset('themes/gallerypuan/assets/img/product_single_02.jpg') }}" class="gallery-img" alt="Gallery 2">
                        <div class="gallery-overlay"><i class='bx bxl-instagram'></i></div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="gallery-item">
                        <img src="{{ asset('themes/gallerypuan/assets/img/product_single_03.jpg') }}" class="gallery-img" alt="Gallery 3">
                        <div class="gallery-overlay"><i class='bx bxl-instagram'></i></div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="gallery-item">
                        <img src="{{ asset('themes/gallerypuan/assets/img/product_single_04.jpg') }}" class="gallery-img" alt="Gallery 4">
                        <div class="gallery-overlay"><i class='bx bxl-instagram'></i></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- 6. Testimoni Pelanggan -->
<section class="py-5 mt-4" style="background-color: #F9F6F0;">
    <div class="container py-5">
        <h2 class="section-title">Cerita Mereka</h2>
        <div class="row g-4 mt-4">
            @php
                // Mengambil 3 ulasan terbaik/terbaru dari database
                $ulasanTerbaik = \Modules\Shop\Entities\Review::where('status', 'approved')
                                    ->where('rating', '>=', 4)
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
            @endphp
            
            @forelse($ulasanTerbaik as $ulasan)
                @php
                    $inisial = strtoupper(substr($ulasan->user->name ?? 'A', 0, 1));
                    $warnaBg = ['#D1A7A0', '#C5A059', '#8C7A6B'][$loop->index % 3];
                @endphp
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white testimonial-img" style="font-size: 24px; font-weight: bold; background-color: {{ $warnaBg }};">{{ $inisial }}</div>
                        <div class="testimonial-stars">
                            @for($i=1; $i<=5; $i++)
                                <i class="bx {{ $i <= $ulasan->rating ? 'bxs-star' : 'bx-star' }}"></i>
                            @endfor
                        </div>
                        <p class="text-luxury fst-italic">"{{ $ulasan->comment ?? 'Sangat memuaskan dan produknya sangat cantik.' }}"</p>
                        <h6 class="fw-bold mt-3" style="color: #2C1E16;">{{ $ulasan->user->name ?? 'Pelanggan Setia' }}</h6>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <p style="color: #A3918E;">Belum ada ulasan untuk saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 7. CTA Penutup -->
<section class="cta-banner">
    <div class="container">
        <h2 class="fw-bold mb-3" style="color: #2C1E16; font-family: 'Playfair Display', serif;">Mulai Perjalanan Eleganmu</h2>
        <p class="text-luxury mb-4" style="font-size: 18px;">Temukan koleksi hijab terbaik untuk menemani gaya muslimah modernmu hari ini.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('products') }}" class="btn-luxury-primary">Belanja Sekarang</a>
            <a href="{{ url('Category') }}" class="btn-luxury-primary" style="background-color: transparent; border: 2px solid #B6867F; color: #2C1E16;">Lihat Koleksi</a>
        </div>
    </div>
</section>

@endsection
