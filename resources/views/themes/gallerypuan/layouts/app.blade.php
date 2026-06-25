<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Gallery Puan.id: Official Site</title>
    @php
        $siteFavicon = \App\Models\Setting::getValue('site_favicon', 'themes/gallerypuan/assets/img/logo.jpg');
    @endphp
    <link rel="icon" type="image/png" href="{{ Str::startsWith($siteFavicon, 'http') ? $siteFavicon : asset($siteFavicon) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- INI OBATNYA: Kita turunkan ke jQuery versi 1.11.1 agar cocok dengan jquery-ui bawaan video --}}
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    @livewireStyles

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',

        'resources/views/themes/gallerypuan/assets/css/main.css',
        'resources/views/themes/gallerypuan/assets/plugins/jqueryui/jquery-ui.css',

        'resources/views/themes/gallerypuan/assets/plugins/jqueryui/jquery-ui.min.js',
        'resources/views/themes/gallerypuan/assets/js/main.js',
    ])

    {{-- OBAT PENAWAR GAP UNTUK HALAMAN SELAIN HOME (Products, Carts, dll) --}}
    <style>
        /* Membunuh margin raksasa bawaan template lama */
        .breadcrumb-section {
            margin-top: 0 !important;
            padding-top: 1.5rem !important; /* Sedikit ruang napas agar tidak menabrak garis navbar */
            background-color: #FAF7F2; /* Mengikuti warna aesthetic kita */
        }
        
        .main-content {
            margin-top: 0 !important;
            background-color: #FAF7F2;
        }

        /* Memastikan warna background body halaman lain ikut aesthetic */
        body {
            background-color: #FAF7F2 !important; 
        }

        /* CSS TOMBOL KERANJANG GLOBAL */
    .add-cart-text { 
        font-size: 13px; color: #4A3F35; text-decoration: none; font-weight: 500; 
        display: inline-flex; align-items: center; gap: 5px; transition: 0.3s; 
        background: #FAF7F2; border: 1px solid #E1DDD7; cursor: pointer; 
        padding: 8px 16px; border-radius: 50px; width: 100%; justify-content: center;
    }
    .add-cart-text:hover { 
        background: #4A3F35; color: #FFFFFF; border-color: #4A3F35; gap: 8px; 
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Ketika tombol wishlist diklik
        $('.wishlist-btn').click(function(e) {
            e.preventDefault();
            
            // Cek apakah pelanggan sudah login
            @guest
                showLuxuryToast('Perhatian', 'Silakan login terlebih dahulu untuk menyimpan produk ke daftar keinginan.', 'warning');
                setTimeout(() => { window.location.href = "{{ route('login') }}"; }, 1500);
                return;
            @endguest

            let btn = $(this);
            let icon = btn.find('i');
            let productId = btn.data('product');
            
            // Animasi kecil saat diklik
            icon.removeClass('bx-heart bxs-heart').addClass('bx-loader bx-spin');

            // Kirim sinyal AJAX ke Controller
            $.ajax({
                url: "{{ route('wishlist.toggle') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {
                    // Hapus animasi loading
                    icon.removeClass('bx-loader bx-spin');
                    
                    if(response.status == 'added') {
                        // Jika ditambahkan, ubah hati jadi merah & penuh
                        icon.addClass('bxs-heart text-danger').removeClass('bx-heart text-muted');
                    } else {
                        // Jika dihapus, kembalikan jadi hati kosong
                        icon.addClass('bx-heart text-muted').removeClass('bxs-heart text-danger');
                    }
                },
                error: function(xhr) {
                    icon.removeClass('bx-loader bx-spin').addClass('bx-heart text-muted');
                    showLuxuryToast('Gagal', 'Terjadi kesalahan sistem. Silakan coba lagi.', 'error');
                }
            });
        });
    });
</script>
</head>
    
    <body class="d-flex flex-column min-vh-100 m-0 p-0" style="background-color: #FAF7F2;"> 

        @include('themes.gallerypuan.shared.header')
        @include('themes.gallerypuan.shared.flash')

        <main class="flex-grow-1 m-0 p-0"> 
            @yield('content')
        </main>
        <livewire:front.chat-widget />

        @include('themes.gallerypuan.shared.footer')
        
    
    @include('themes.gallerypuan.shared.quick_view_modal')

    @livewireScripts
</body>
</html>