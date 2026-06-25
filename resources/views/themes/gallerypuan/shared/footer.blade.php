<style>
    .aesthetic-footer {
        background-color: #EFEBE4;
        padding: 60px 0 20px 0;
        border-top: 1px solid #E1DDD7;
        font-family: 'Poppins', sans-serif;
        color: #4A3F35;
    }
    .aesthetic-footer .footer-title { 
        font-size: 16px; 
        font-weight: 600; 
        margin-bottom: 20px; 
        color: #4A3F35; 
        font-family: 'Playfair Display', serif;
    }
    .aesthetic-footer .footer-link { 
        color: #8C7A6B; 
        text-decoration: none; 
        font-size: 14px; 
        display: block; 
        margin-bottom: 10px; 
        transition: 0.3s; 
    }
    .aesthetic-footer .footer-link:hover { 
        color: #4A3F35; 
        padding-left: 5px; 
    }
</style>

<footer class="aesthetic-footer mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <a class="d-flex align-items-center mb-3 text-decoration-none" href="{{ url('/') }}">
                    @php
                        $siteLogo = \App\Models\Setting::getValue('site_logo', 'themes/gallerypuan/assets/img/logo.jpg');
                    @endphp
                    <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset($siteLogo) }}" alt="Logo" style="height: 50px; width: auto; object-fit: contain; margin-right: 15px; border-radius: 50%;">
                </a>
                <p style="color: #8C7A6B; font-size: 14px; line-height: 1.6; padding-right: 20px;">
                    Gallery Puan adalah destinasi utama untuk hijab premium dan busana muslimah elegan dengan nuansa warna pastel yang menenangkan.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" style="color: #4A3F35;"><i class="bx bxl-instagram fs-4"></i></a>
                    <a href="#" style="color: #4A3F35;"><i class="bx bxl-tiktok fs-4"></i></a>
                    <a href="#" style="color: #4A3F35;"><i class="bx bxl-whatsapp fs-4"></i></a>
                </div>
            </div>
            
            <div class="col-6 col-lg-2 mb-4">
                <h5 class="footer-title">Jelajahi</h5>
                <a href="{{ url('/') }}" class="footer-link">Beranda</a>
                <a href="{{ url('/#kategori') }}" class="footer-link">Kategori Produk</a>
                <a href="{{ route('products.index') }}" class="footer-link">Koleksi Terbaru</a>
            </div>

            <div class="col-6 col-lg-3 mb-4">
                <h5 class="footer-title">Layanan Pelanggan</h5>
                <a href="#" class="footer-link">Cara Pemesanan</a>
                <a href="#" class="footer-link">Konfirmasi Pembayaran</a>
                <a href="#" class="footer-link">Kebijakan Pengembalian</a>
            </div>

            <div class="col-lg-3 mb-4">
                <h5 class="footer-title">Hubungi Kami</h5>
                <p style="color: #8C7A6B; font-size: 14px; margin-bottom: 8px;"><i class="bx bx-map me-2"></i> Jl. Aesthetic Hijab No. 12, Jakarta</p>
                <p style="color: #8C7A6B; font-size: 14px; margin-bottom: 8px;"><i class="bx bx-envelope me-2"></i> hello@gallerypuan.id</p>
                <p style="color: #8C7A6B; font-size: 14px; margin-bottom: 8px;"><i class="bx bx-phone me-2"></i> +62 812-3456-7890</p>
            </div>
        </div>
        
        <div class="border-top text-center pt-4 mt-2" style="border-color: #E1DDD7 !important;">
            <p style="color: #8C7A6B; font-size: 13px; margin-bottom: 0;">&copy; {{ date('Y') }} Gallery Puan. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>