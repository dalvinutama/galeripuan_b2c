<style>
    /* --- DESAIN MEGA MENU ALA SOCIOLLA --- */
    .mega-dropdown {
        position: static !important; /* Wajib agar menu bisa selebar layar/container */
    }
    .mega-menu-container {
        width: 100%;
        left: 0;
        right: 0;
        border: none;
        border-top: 1px solid #E1DDD7;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        padding: 0;
        margin-top: 0;
        overflow: hidden;
    }
    .mega-menu-wrapper {
        display: flex;
        min-height: 300px;
    }
    /* --- UPDATE: MEGA MENU GRID KOLOM --- */
    .mega-sidebar {
        width: 45%; /* Diperlebar agar muat beberapa kolom */
        background-color: #F9F6F0;
        padding: 20px 0;
        border-right: 1px solid #E8E2D9;
    }
    
    .mega-sidebar-grid {
        display: grid;
        grid-template-rows: repeat(5, auto); /* MENTOK 5 BARIS KE BAWAH */
        grid-auto-flow: column; /* OTOMATIS LANJUT KE SAMPING JIKA LEBIH DARI 5 */
        gap: 5px 15px; /* Jarak atas-bawah 5px, kiri-kanan 15px */
        padding: 0 20px;
    }

    .mega-sidebar-item {
        padding: 10px 15px;
        color: #4A3F35;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        transition: 0.2s;
        border-radius: 8px; /* Dibuat melengkung seperti tombol */
    }

    .mega-sidebar-item:hover, .mega-sidebar-item.active {
        background-color: #FFFFFF;
        color: #C5A059;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); /* Bayangan estetik */
    }

    .mega-content {
        width: 55%; /* Sisa ruang untuk konten kanan */
        padding: 40px;
        background-color: #FFFFFF;
    } 
    .mega-content-panel {
        display: none;
        animation: fadeIn 0.3s;
    }
    .mega-content-panel.active {
        display: block;
    }
    .mega-title {
        font-size: 13px;
        color: #C5A059;
        font-weight: 700;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .mega-link-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .mega-link-list li { margin-bottom: 12px; }
    .mega-link-list a {
        color: #4A3F35;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
        font-weight: 500;
    }
    .mega-link-list a:hover {
        color: #C5A059;
        padding-left: 5px; /* Efek maju sedikit saat di-hover */
    }
    @media (max-width: 991px) {
        .mega-menu-wrapper { flex-direction: column; }
        .mega-sidebar { width: 100%; border-right: none; border-bottom: 1px solid #E8E2D9; }
        .mega-content { width: 100%; padding: 20px; }
    }
    /* Efek Dropdown muncul saat di-hover */
    .dropdown-hover:hover .dropdown-menu {
        display: block;
        animation: fadeIn 0.2s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Mengikuti tinggi awal (py-3 bawaan bootstrap) dan warna persis footer */
    .premium-navbar {
        background-color: #FFFDFB !important; /* Warna sama persis dengan footer */
        /* Garis tipis pembatas di bawah navbar, sama seperti border-top di footer */
        border-bottom: 1px solid #E8E2D9 !important; 
    }
    
    .nav-icon-link {
        color: #4A3F35 !important;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    
    .nav-icon-link:hover {
        color: #C5A059 !important; 
        transform: translateY(-2px);
    }
    
    .main-nav-link {
        color: #2C1E16 !important; /* Warna hitam elegan (Deep Espresso) */
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        padding-bottom: 5px;
    }
    .main-nav-link:hover {
        color: #B6867F !important; /* Warna pink */
    }
    .main-nav-link.active {
        color: #B6867F !important; /* Warna pink saat aktif */
        border-bottom: 2px solid #B6867F;
        font-weight: 600;
    }

    .custom-dropdown {
        border-radius: 12px;
        padding: 10px;
        min-width: 220px;
        border: 1px solid #E8E2D9;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }

    .custom-drop-item {
        border-radius: 8px;
        padding: 8px 15px;
        color: #4A3F35;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .custom-drop-item:hover {
        background-color: #F9F6F0;
        color: #C5A059;
    }

    .custom-drop-item.text-danger:hover {
        background-color: #FFF5F5;
        color: #DC3545 !important;
    }
    /* --- DESAIN SEARCH BAR ALA SOCIOLLA --- */
    .search-bar-inline {
        width: 320px; /* Panjang kotak pencarian */
        border-radius: 25px; /* Membuat ujungnya melengkung/lonjong */
        border: 1px solid #E8E2D9;
        background-color: #F9F6F0;
        padding: 8px 45px 8px 20px;
        font-size: 13px;
        color: #4A3F35;
        transition: all 0.3s ease;
    }
    .search-bar-inline:focus {
        outline: none;
        border-color: #C5A059;
        box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.1);
        background-color: #FFFFFF;
    }
    .search-btn-inline {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #D1A7A0;
        padding: 5px;
        transition: 0.2s;
    }
    .search-btn-inline:hover {
        color: #C5A059;
    }
    @media (max-width: 991px) {
        .search-bar-inline {
            width: 100%; /* Agar responsif penuh kalau dibuka di HP */
            margin-bottom: 15px;
        }
    }
    
    /* --- CUSTOM ULTRA-PREMIUM SWEETALERT LOGOUT --- */
    .ultra-premium-logout-popup {
        border-radius: 24px !important;
        background: transparent !important;
        box-shadow: 0 40px 100px rgba(0,0,0,0.25) !important;
        border: none !important;
        width: 440px !important;
        padding: 0 !important;
    }
    .swal2-html-container {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* -- MOBILE OFFCANVAS NAVBAR -- */
    @media (max-width: 991px) {
        .mobile-offcanvas {
            background-color: #FFFDFB !important;
            max-width: 320px !important;
            border-left: 1px solid #E8E2D9 !important;
        }
        .mobile-offcanvas .navbar-nav {
            text-align: left !important;
            align-items: flex-start !important;
            flex-direction: column !important;
            width: 100%;
        }
        .mobile-offcanvas .nav-item {
            width: 100%;
            border-bottom: 1px solid #E8E2D9;
        }
        .mobile-offcanvas .nav-item:last-child {
            border-bottom: none;
        }
        .mobile-offcanvas .nav-link {
            padding: 12px 0 !important;
            width: 100%;
            display: flex;
            align-items: center;
        }
        .mobile-offcanvas .mega-dropdown .bx-chevron-down {
            margin-left: auto;
        }
        .mobile-icon-text {
            display: inline-block !important;
            margin-left: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #4A3F35;
        }
        .mobile-offcanvas .ms-auto {
            margin-top: 10px !important;
            padding-top: 10px !important;
        }
        .search-bar-inline {
            width: 100% !important;
        }
        .mobile-icon-text { display: none; } /* Tersembunyi di desktop */

        /* Quick-access icons di navbar bar atas (mobile only) */
        .mobile-quick-icons {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            margin-right: 8px;
        }
        .mobile-quick-icons a {
            position: relative;
            color: #4A3F35;
            font-size: 22px;
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 4px;
        }
        .mobile-quick-icons .badge-dot {
            position: absolute;
            top: 0px;
            right: 0px;
            min-width: 16px;
            height: 16px;
            font-size: 9px;
            background-color: #C5A059;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            padding: 0 3px;
            border: 1.5px solid white;
        }
        /* Search bar di tengah navbar mobile */
        .mobile-search-bar {
            flex: 1;
            margin: 0 10px;
        }
        .mobile-search-bar form {
            position: relative;
            display: flex;
            align-items: center;
        }
        .mobile-search-bar input {
            width: 100%;
            border: 1.5px solid #E8E2D9;
            border-radius: 50px;
            padding: 7px 36px 7px 14px;
            font-size: 13px;
            background-color: #F9F6F0;
            color: #4A3F35;
            outline: none;
            box-shadow: none;
        }
        .mobile-search-bar input:focus {
            border-color: #C5A059;
            background-color: #fff;
        }
        .mobile-search-bar button {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #4A3F35;
            font-size: 17px;
            padding: 0;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
    }
    .mobile-icon-text { display: none; } /* Tersembunyi di desktop */

    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&display=swap');
</style>

<nav class="navbar navbar-expand-lg py-3 sticky-top premium-navbar" style="z-index: 1030; margin-bottom: 0;">
    <div class="container d-flex justify-content-between align-items-center" style="position: relative;">
        
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            @php
                $siteLogo = \App\Models\Setting::getValue('site_logo', 'themes/gallerypuan/assets/img/logo.jpg');
            @endphp
            <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset($siteLogo) }}" alt="Logo Gallery Puan" style="width: 55px; height: 55px; object-fit: cover; border-radius: 50%;">
        </a>
        
        {{-- Ikon Pintas Mobile (hanya tampil di layar kecil) --}}
        @php
            $cart_mb = \Illuminate\Support\Facades\DB::table('shop_carts')->where('user_id', auth()->id() ?? 0)->first();
            $cartCount_mb = $cart_mb ? \Illuminate\Support\Facades\DB::table('shop_cart_items')->where('cart_id', $cart_mb->id)->count() : 0;
            $wishlistCount_mb = auth()->check() ? \Modules\Shop\Entities\Wishlist::where('user_id', auth()->id())->count() : 0;
        @endphp
        {{-- Search Bar Tengah (mobile only) --}}
        <div class="mobile-search-bar d-lg-none">
            <form action="{{ route('products.index') }}" method="GET">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari produk..."
                       autocomplete="off">
                <button type="submit"><i class="bx bx-search"></i></button>
            </form>
        </div>

        <div class="mobile-quick-icons d-lg-none">
            @auth
            {{-- Ikon Notifikasi --}}
            @php
                $unreadNotifCount_mb = auth()->user()->unreadNotifications->count();
            @endphp
            <a href="#" title="Notifikasi" data-bs-toggle="dropdown" id="notifMobileBtn">
                <i class="bx bx-bell"></i>
                @if($unreadNotifCount_mb > 0)
                    <span class="badge-dot">{{ $unreadNotifCount_mb }}</span>
                @endif
            </a>
            @endauth
            @auth
            {{-- Ikon Wishlist --}}
            <a href="{{ route('wishlist.standalone') }}" title="Daftar Keinginan">
                <i class="bx bx-heart"></i>
                @if($wishlistCount_mb > 0)
                    <span class="badge-dot">{{ $wishlistCount_mb }}</span>
                @endif
            </a>
            {{-- Ikon Keranjang --}}
            <a href="{{ route('carts.index') }}" title="Keranjang Belanja">
                <i class="bx bx-shopping-bag"></i>
                @if($cartCount_mb > 0)
                    <span class="badge-dot">{{ $cartCount_mb }}</span>
                @endif
            </a>
            @endauth
        </div>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav">
            <i class="bx bx-menu" style="font-size: 28px; color: #4A3F35;"></i>
        </button>
        
        <div class="offcanvas-lg offcanvas-end mobile-offcanvas" tabindex="-1" id="navbarNav" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header border-bottom" style="background-color: #FAF8F5;">
                <h5 class="offcanvas-title d-flex align-items-center gap-2" id="navbarNavLabel" style="font-family: 'Playfair Display', serif; color: #2C1E16; font-weight: 700; font-size: 16px;">
                    <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset($siteLogo) }}" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                    Menu Utama
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" data-bs-target="#navbarNav" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body p-4 p-lg-0">
                <!-- Mobile Search Bar (Only shown on mobile) -->
                <div class="d-lg-none w-100 mb-3 border-bottom pb-3">
                    <h6 class="text-muted fw-bold mb-2 mt-2" style="font-size: 11px; letter-spacing: 1px; text-transform: uppercase;">Pencarian</h6>
                    <form action="{{ route('products.index') }}" method="GET" class="position-relative m-0">
                        <input type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                class="form-control shadow-none search-bar-inline" 
                                placeholder="Cari hijab favorit kamu" 
                                autocomplete="off"
                                oninput="if(this.value === '') window.location.href='{{ route('products.index') }}';">
                        <button type="submit" class="search-btn-inline">
                            <i class="bx bx-search fs-5"></i>
                        </button>
                    </form>
                </div>

                <ul class="navbar-nav mx-auto text-center gap-lg-4 mt-3 mt-lg-0" style="font-size: 14px; font-weight: 500; font-family: 'Poppins', sans-serif;">
                    <li class="nav-item"><a class="nav-link main-nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a></li>
                @php
                    // Memanggil data kategori
                    $mainCategories = \Modules\Shop\Entities\Category::orderBy('name', 'asc')->get();
                @endphp

                <li class="nav-item dropdown dropdown-hover mega-dropdown">
                    <a class="nav-link main-nav-link d-flex align-items-center gap-1 {{ request()->is('Category*') || request()->is('category*') ? 'active' : '' }}" href="{{ url('/Category') }}">
                        Kategori <i class='bx bx-chevron-down' style="font-size: 16px;"></i>
                    </a>
                    
                    <div class="dropdown-menu mega-menu-container">
                        <div class="mega-menu-wrapper">
                            
                            <div class="mega-sidebar">
                                <div class="mega-sidebar-grid">
                                    @forelse($mainCategories as $index => $mainCat)
                                        <div class="mega-sidebar-item {{ $index == 0 ? 'active' : '' }}" onmouseover="showMegaContent('mega-panel-{{ $mainCat->id }}', this)">
                                            <i class='bx bx-purchase-tag-alt text-muted' style="font-size: 16px;"></i>
                                            <span class="text-truncate">{{ $mainCat->name }}</span>
                                        </div>
                                    @empty
                                        <div class="mega-sidebar-item">Belum ada kategori</div>
                                    @endforelse
                                </div>
                                
                                <hr class="my-3 mx-4" style="border-color: #E8E2D9;">
                                <div class="px-4">
                                    <a href="{{ url('/Category') }}" class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #D1A7A0; color: white; border-radius: 8px; font-size: 13px; transition: 0.3s;">
                                        <i class='bx bx-grid-alt'></i> LIHAT SEMUA KATEGORI
                                    </a>
                                </div>
                            </div>

                            <div class="mega-content">
                                @foreach($mainCategories as $index => $mainCat)
                                    <div id="mega-panel-{{ $mainCat->id }}" class="mega-content-panel {{ $index == 0 ? 'active' : '' }}">
                                        <div class="row h-100 align-items-center">
                                            <div class="col-md-5">
                                                <h6 class="mega-title">Koleksi {{ $mainCat->name }} <i class='bx bx-chevron-right'></i></h6>
                                                <ul class="mega-link-list">
                                                    <li><a href="{{ shop_category_link($mainCat) }}">Lihat Semua Produk</a></li>
                                                    <li><a href="{{ shop_category_link($mainCat) }}?sort=publish_date&order=desc">Produk Terbaru</a></li>
                                                    <li><a href="{{ shop_category_link($mainCat) }}?sort=price&order=asc">Harga: Rendah - Tinggi</a></li>
                                                    <li><a href="{{ shop_category_link($mainCat) }}?sort=price&order=desc">Harga: Tinggi - Rendah</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="p-4 rounded text-center h-100 d-flex flex-column justify-content-center align-items-center" style="background-color: #F9F6F0; border: 1px dashed #D1A7A0;">
                                                    <i class='bx bx-star text-warning mb-2' style="font-size: 2.5rem; color:#C5A059 !important;"></i>
                                                    <h6 class="fw-bold" style="color: #4A3F35;">Eksplorasi {{ $mainCat->name }}!</h6>
                                                    <p class="text-muted small mb-3">Temukan berbagai pilihan hijab elegan yang sesuai dengan karaktermu.</p>
                                                    <a href="{{ shop_category_link($mainCat) }}" class="btn btn-sm text-white rounded-pill px-4" style="background-color: #D1A7A0; border:none; transition: 0.3s;">Belanja Sekarang</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link main-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a></li>
                <li class="nav-item"><a class="nav-link main-nav-link {{ request()->is('tentang-kami') ? 'active' : '' }}" href="{{ url('/tentang-kami') }}">Tentang Kami</a></li>
            </ul>
            
           <ul class="navbar-nav ms-auto mt-3 mt-lg-0 flex-row justify-content-center gap-4 align-items-center"> 
                
                <!-- Desktop Search Bar -->
                <li class="nav-item me-lg-3 d-none d-lg-block">
                    <form action="{{ route('products.index') }}" method="GET" class="position-relative m-0">
                        <input type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                class="form-control shadow-none search-bar-inline" 
                                placeholder="Cari hijab favorit kamu" 
                                autocomplete="off"
                                oninput="if(this.value === '') window.location.href='{{ route('products.index') }}';">
                        <button type="submit" class="search-btn-inline">
                            <i class="bx bx-search fs-5"></i>
                        </button>
                    </form>
                </li>

                @auth
                @php
                    // --- AMBIL DATA KERANJANG ---
                    $cart = \Illuminate\Support\Facades\DB::table('shop_carts')->where('user_id', auth()->id())->first();
                    $cartCount = $cart ? \Illuminate\Support\Facades\DB::table('shop_cart_items')->where('cart_id', $cart->id)->count() : 0;
                    
                    // --- MENGAMBIL NOTIFIKASI ASLI DARI DATABASE ---
                    $unreadNotifCount = auth()->user()->unreadNotifications->count();
                    $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get(); // Ambil 5 terbaru
                    
                    // --- AMBIL DATA WISHLIST ---
                    $wishlistCount = \Modules\Shop\Entities\Wishlist::where('user_id', auth()->id())->count();
                @endphp
                
                <li class="nav-item position-relative">
                    <a class="nav-link nav-icon-link" href="{{ route('wishlist.standalone') }}">
                        <div class="position-relative d-inline-block">
                            <i class="bx bx-heart fs-4"></i>
                            @if($wishlistCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="font-size: 0.6rem; background-color: #C5A059;">{{ $wishlistCount }}</span>
                            @endif
                        </div>
                        <span class="mobile-icon-text">Daftar Keinginan</span>
                    </a>
                </li>

                <li class="nav-item dropdown position-relative">
                    <a class="nav-link nav-icon-link" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="position-relative d-inline-block">
                            <i class="bx bx-bell fs-4"></i>
                            @if($unreadNotifCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill notif-badge border border-white" style="font-size: 0.6rem; background-color: #C5A059;">
                                    {{ $unreadNotifCount }}
                                </span>
                            @endif
                        </div>
                        <span class="mobile-icon-text">Notifikasi</span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown bg-white p-0" aria-labelledby="notifDropdown" style="width: 340px; border: 1px solid #E8E2D9; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1) !important;">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background-color: #FAF8F5;">
                            <h6 class="mb-0 fw-bold" style="color: #4A3F35;"><i class='bx bx-bell text-gold me-1'></i> Notifikasi</h6>
                            @if($unreadNotifCount > 0)
                                <span class="badge rounded-pill notif-badge" style="background-color: #C5A059;">{{ $unreadNotifCount }} Baru</span>
                            @endif
                        </div>
                        
                        <div style="max-height: 320px; overflow-y: auto;">
                            @forelse($notifications as $notif)
                                <a href="{{ $notif->data['url'] ?? '#' }}" class="dropdown-item p-3 text-wrap text-break" style="white-space: normal; background-color: #FCFAF7; transition: 0.3s; border-bottom: 1.5px solid #D2C6B6 !important;">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color: #F0EAE1; min-width: 40px; height: 40px;">
                                            <i class='bx bx-shopping-bag fs-5' style="color: #C5A059;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold" style="font-size: 13px; color: #4A3F35;">{{ $notif->data['title'] ?? 'Pemberitahuan' }}</h6>
                                            <p class="mb-1 text-muted lh-sm" style="font-size: 12px;">{{ $notif->data['message'] ?? '' }}</p>
                                            <small class="text-muted fw-medium" style="font-size: 10px;"><i class='bx bx-time-five'></i> {{ $notif->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-5 text-center text-muted">
                                    <i class='bx bx-bell-off fs-1 opacity-25 mb-2'></i>
                                    <p class="mb-0 small fw-medium">Belum ada notifikasi baru.</p>
                                </div>
                            @endforelse
                        </div>
                        

                    </ul>
                </li>
                
                <li class="nav-item position-relative me-lg-3">
                    <a class="nav-link nav-icon-link" href="{{ route('carts.index') }}">
                        <div class="position-relative d-inline-block">
                            <i class="bx bx-shopping-bag fs-4"></i>
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="font-size: 0.6rem; background-color: #C5A059;">{{ $cartCount }}</span>
                            @endif
                        </div>
                        <span class="mobile-icon-text">Keranjang Belanja</span>
                    </a>
                </li>
                
                <li class="nav-item dropdown d-flex align-items-center border-start ps-lg-4" style="border-color: #E8E2D9 !important;">
                    <a class="nav-link d-flex align-items-center gap-2 nav-icon-link" href="#" id="navbarUser" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block fw-semibold" style="font-size: 14px; letter-spacing: 0.5px;">{{ Auth::user()->name }}</span>
                        <i class="bx bx-user-circle fs-3"></i>
                        <span class="mobile-icon-text">{{ Auth::user()->name }}</span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown bg-white">
                        <li class="px-3 py-2 d-md-none text-center">
                            <span class="fw-bold" style="color: #4A3F35;">{{ Auth::user()->name }}</span>
                            <hr class="dropdown-divider mt-2 mb-0">
                        </li>
                        
                        <li><a class="dropdown-item custom-drop-item" href="{{ route('profile.index') }}"><i class="bx bx-user"></i> Akun Saya</a></li>
                        <li><a class="dropdown-item custom-drop-item" href="{{ route('orders.index') }}"><i class="bx bx-receipt"></i> Pesanan Saya</a></li>
                        
                        <li><hr class="dropdown-divider" style="border-color: #E8E2D9; margin: 8px 0;"></li>
                        
                        <li><a href="#" onclick="confirmLogout(event, '{{ route('logout.gampang') }}')" class="dropdown-item custom-drop-item text-danger"><i class="bx bx-log-out"></i> Keluar</a></li>
                    </ul>
                </li>

                @else
                <li class="nav-item">
                    <a class="nav-link nav-icon-link" href="{{ route('login') }}">
                        <i class="bx bx-shopping-bag fs-4"></i>
                        <span class="mobile-icon-text">Masuk / Daftar</span>
                    </a>
                </li>
                <li class="nav-item ms-lg-3 d-none d-lg-block"><a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('login') }}" style="font-size: 14px; font-weight: 500;">Masuk</a></li>
                @endauth
            </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    function showMegaContent(panelId, element) {
        // Hilangkan class active dari semua sidebar (kiri)
        document.querySelectorAll('.mega-sidebar-item').forEach(el => el.classList.remove('active'));
        // Tambahkan efek active ke elemen yang sedang di-hover
        element.classList.add('active');

        // Sembunyikan semua panel konten (kanan)
        document.querySelectorAll('.mega-content-panel').forEach(el => el.classList.remove('active'));
        // Tampilkan panel yang sesuai ID-nya
        document.getElementById(panelId).classList.add('active');
    }

    // --- FITUR LOGOUT DENGAN DESAIN ESTETIK ---
    function confirmLogout(event, logoutUrl) {
        event.preventDefault(); // Mencegah pindah halaman langsung
        
        Swal.fire({
            html: `
                <div style="background-color: #FFFFFF; border-radius: 24px; overflow: hidden; position: relative;">
                    <!-- Dekorasi Garis Emas Atas -->
                    <div style="height: 5px; width: 100%; background: linear-gradient(90deg, #D1A7A0, #C5A059, #D1A7A0);"></div>
                    
                    <div style="padding: 45px 35px 35px;">
                        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 25px;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: #FAF7F2; border: 1px solid #E8E2D9; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 0 15px rgba(197, 160, 89, 0.05);">
                                <i class="bx bx-log-out" style="font-size: 34px; color: #C5A059; margin-left: 6px;"></i>
                            </div>
                        </div>
                        
                        <h3 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 600; color: #2C1E16; margin-bottom: 12px; font-size: 24px; letter-spacing: -0.5px;">Keluar Akun</h3>
                        <p style="color: #6C5A49; font-size: 14px; margin-bottom: 35px; line-height: 1.6; font-family: 'Poppins', sans-serif;">
                            Apakah Anda yakin ingin mengakhiri sesi ini?
                        </p>
                        
                        <div style="display: flex; gap: 12px; justify-content: center;">
                            <button onclick="Swal.close()" style="flex: 1; padding: 12px 20px; border-radius: 8px; border: 1px solid #E8E2D9; background: #FFFFFF; color: #4A3F35; font-weight: 500; font-family: 'Poppins', sans-serif; font-size: 14px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='#F9F6F0'; this.style.borderColor='#D2C6B6';" onmouseout="this.style.background='#FFFFFF'; this.style.borderColor='#E8E2D9';">
                                Batal
                            </button>
                            <button onclick="executeLogout('${logoutUrl}')" style="flex: 1; padding: 12px 20px; border-radius: 8px; border: none; background: #2C1E16; color: #FFFFFF; font-weight: 500; font-family: 'Poppins', sans-serif; font-size: 14px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(44, 30, 22, 0.15);" onmouseover="this.style.background='#C5A059'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#2C1E16'; this.style.transform='translateY(0)';">
                                Keluar
                            </button>
                        </div>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            showCancelButton: false,
            padding: '0',
            background: 'transparent',
            backdrop: `rgba(20, 15, 10, 0.65)`, /* Gelap dramatis */
            customClass: {
                popup: 'ultra-premium-logout-popup',
            }
        });
    }

    function executeLogout(logoutUrl) {
        Swal.fire({
            html: `
                <div style="background-color: #FFFFFF; border-radius: 24px; padding: 50px 30px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.1);">
                    <div style="width: 50px; height: 50px; border: 3px solid #E8E2D9; border-top-color: #C5A059; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                    <style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
                    <h4 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 600; color: #2C1E16; margin: 0; font-size: 18px;">Memproses</h4>
                    <p style="color: #A3917F; font-size: 13px; margin-top: 8px; margin-bottom: 0;">Mohon tunggu sebentar.</p>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            padding: '0',
            background: 'transparent',
            backdrop: `rgba(20, 15, 10, 0.65)`,
            customClass: {
                popup: 'ultra-premium-logout-popup'
            },
            didOpen: () => {
                setTimeout(() => {
                    window.location.href = logoutUrl;
                }, 1000); // 1 detik loading elegan sebelum keluar
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cartForms = document.querySelectorAll('.add-to-cart-form');
        const cartNavIcon = document.querySelector('.nav-icon-link .bx-shopping-bag');

        cartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let img = form.closest('.card-product') ? form.closest('.card-product').querySelector('.product-image-box img') : null;
                if(!img) {
                    img = document.querySelector('#product-images .active img');
                }

                if(img && cartNavIcon) {
                    let imgClone = img.cloneNode();
                    let btnRect = form.querySelector('button[type="submit"]').getBoundingClientRect();
                    let cartRect = cartNavIcon.getBoundingClientRect();
                    let startX = btnRect.left + (btnRect.width / 2) - 15; 
                    let startY = btnRect.top + (btnRect.height / 2) - 15;

                    imgClone.style.position = 'fixed';
                    imgClone.style.top = startY + 'px';
                    imgClone.style.left = startX + 'px';
                    imgClone.style.width = '30px';
                    imgClone.style.height = '30px';
                    imgClone.style.zIndex = '9999';
                    imgClone.style.borderRadius = '50%';
                    imgClone.style.objectFit = 'cover';
                    // Kombinasi linear untuk gerak horizontal dan ease-in untuk vertikal agar sedikit melengkung
                    imgClone.style.transition = 'left 0.5s linear, top 0.5s cubic-bezier(0.5, 0, 1, 0.5), width 0.5s ease, height 0.5s ease, opacity 0.5s ease';
                    imgClone.style.opacity = '1';
                    imgClone.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
                    imgClone.style.border = '1px solid #C5A059';

                    document.body.appendChild(imgClone);

                    setTimeout(() => {
                        imgClone.style.top = (cartRect.top + 10) + 'px';
                        imgClone.style.left = (cartRect.left + 10) + 'px';
                        imgClone.style.width = '10px';
                        imgClone.style.height = '10px';
                        imgClone.style.opacity = '0';
                    }, 20);

                    // Bergetar sedikit keranjangnya saat barang masuk
                    setTimeout(() => {
                        cartNavIcon.style.transform = 'scale(1.3) rotate(-5deg)';
                        cartNavIcon.style.transition = '0.15s ease-out';
                        cartNavIcon.style.color = '#D1A7A0';
                        setTimeout(() => {
                            cartNavIcon.style.transform = 'scale(1) rotate(0)';
                            cartNavIcon.style.color = '';
                        }, 200);
                    }, 450);

                    setTimeout(() => {
                        imgClone.remove();
                        form.submit(); 
                    }, 500);
                } else {
                    form.submit();
                }
            });
        });
    });


</script>