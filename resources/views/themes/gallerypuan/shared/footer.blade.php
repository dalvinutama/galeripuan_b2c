<style>
    .aesthetic-footer {
        background-color: #EFEBE4;
        padding: 60px 0 0 0;
        border-top: 1px solid #E1DDD7;
        font-family: 'Poppins', sans-serif;
        color: #4A3F35;
    }
    .aesthetic-footer .footer-brand-name {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
        color: #2C1E16;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .aesthetic-footer .footer-tagline {
        color: #8C7A6B;
        font-size: 13.5px;
        line-height: 1.7;
        max-width: 280px;
    }
    .aesthetic-footer .footer-social a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #E1DDD7;
        color: #4A3F35;
        font-size: 17px;
        transition: 0.3s;
        text-decoration: none;
    }
    .aesthetic-footer .footer-social a:hover {
        background-color: #C5A059;
        color: #fff;
        transform: translateY(-2px);
    }
    .aesthetic-footer .footer-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #2C1E16;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    .aesthetic-footer .footer-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 24px;
        height: 2px;
        background-color: #C5A059;
        border-radius: 2px;
    }
    .aesthetic-footer .footer-link {
        color: #8C7A6B;
        text-decoration: none;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        transition: 0.3s;
    }
    .aesthetic-footer .footer-link:hover {
        color: #4A3F35;
        padding-left: 4px;
    }
    .aesthetic-footer .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
        color: #8C7A6B;
        font-size: 13.5px;
        line-height: 1.5;
    }
    .aesthetic-footer .footer-contact-item i {
        color: #C5A059;
        font-size: 17px;
        margin-top: 1px;
        flex-shrink: 0;
    }
    .aesthetic-footer .footer-bottom {
        border-top: 1px solid #E1DDD7;
        padding: 18px 0;
        margin-top: 50px;
    }
    .aesthetic-footer .footer-bottom p {
        color: #8C7A6B;
        font-size: 12.5px;
        margin: 0;
    }

    /* === MOBILE RESPONSIVENESS === */
    @media (max-width: 991px) {
        .aesthetic-footer {
            padding: 32px 0 0 0;
        }
        .aesthetic-footer .footer-brand-name {
            font-size: 18px;
        }
        .aesthetic-footer .footer-tagline {
            max-width: 100%;
            font-size: 13px;
            margin-bottom: 12px !important;
        }
        .aesthetic-footer .footer-social {
            margin-bottom: 0 !important;
        }
        .aesthetic-footer .footer-section-title {
            margin-bottom: 12px;
            margin-top: 4px;
        }
        .aesthetic-footer .footer-link {
            margin-bottom: 7px;
            font-size: 13px;
        }
        .aesthetic-footer .footer-contact-item {
            margin-bottom: 8px;
            font-size: 13px;
        }
        .aesthetic-footer .footer-bottom {
            margin-top: 24px;
            padding: 14px 0;
        }
        .footer-mobile-gap {
            row-gap: 1.4rem !important;
        }
    }
</style>

<footer class="aesthetic-footer mt-auto">
    <div class="container">
        <div class="row g-5 footer-mobile-gap">

            {{-- Kolom 1: Brand & Sosial Media --}}
            <div class="col-lg-4 col-md-12">
                <a class="d-flex align-items-center mb-3 text-decoration-none" href="{{ url('/') }}">
                    @php
                        $siteLogo = \App\Models\Setting::getValue('site_logo', 'themes/gallerypuan/assets/img/logo.jpg');
                    @endphp
                    <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset($siteLogo) }}" alt="Logo Gallery Puan" style="height: 45px; width: 45px; object-fit: cover; border-radius: 50%; margin-right: 12px; border: 2px solid #E1DDD7;">
                    <span class="footer-brand-name">Gallery Puan</span>
                </a>
                <p class="footer-tagline mb-4">
                    Destinasi utama untuk hijab premium & busana muslimah elegan. Tampil anggun setiap hari bersama koleksi terkurasi kami.
                </p>
                <div class="footer-social d-flex gap-2">
                    <a href="https://www.instagram.com/gallerypuan.id?igsh=a2ZwbjZkY3lkZGFq" target="_blank" title="Instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="https://www.tiktok.com/@gallery.puan.id?_r=1&_t=ZS-97pTMfl3hVX" target="_blank" title="TikTok"><i class="bx bxl-tiktok"></i></a>
                    <a href="https://wa.me/6285822283385" target="_blank" title="WhatsApp"><i class="bx bxl-whatsapp"></i></a>
                </div>
            </div>

            {{-- Kolom 2: Hubungi Kami --}}
            <div class="col-lg-6 col-6">
                <h6 class="footer-section-title">Hubungi Kami</h6>
                <div class="footer-contact-item">
                    <i class="bx bx-map"></i>
                    <span>Jl. Raya Desa Kapur, Kapur, Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat, Indonesia</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bx bx-envelope"></i>
                    <a href="mailto:gallerypuan2023@gmail.com" style="color: #8C7A6B; text-decoration: none;">gallerypuan2023@gmail.com</a>
                </div>
                <div class="footer-contact-item">
                    <i class="bx bx-phone"></i>
                    <a href="https://wa.me/6285822283385" target="_blank" style="color: #8C7A6B; text-decoration: none;">+62 858-2228-3385</a>
                </div>
                <div class="footer-contact-item">
                    <i class="bx bx-time"></i>
                    <span>Senin – Sabtu, 08.00 – 17.00 WIB</span>
                </div>
            </div>

            {{-- Kolom 3: Jelajahi --}}
            <div class="col-lg-2 col-6">
                <h6 class="footer-section-title">Jelajahi</h6>
                <a href="{{ url('/') }}" class="footer-link">
                    <i class="bx bx-home-alt"></i> Beranda
                </a>
                <a href="{{ url('/#kategori') }}" class="footer-link">
                    <i class="bx bx-category"></i> Kategori Produk
                </a>
                <a href="{{ route('products.index') }}" class="footer-link">
                    <i class="bx bx-purchase-tag-alt"></i> Koleksi Terbaru
                </a>
                <a href="{{ url('/tentang-kami') }}" class="footer-link">
                    <i class="bx bx-info-circle"></i> Tentang Kami
                </a>
            </div>

        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; {{ date('Y') }} Gallery Puan. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</footer>