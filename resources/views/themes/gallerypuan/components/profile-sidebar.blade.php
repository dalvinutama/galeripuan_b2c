<style>
    /* --- DESAIN PREMIUM SIDEBAR PROFIL --- */
    .profile-sidebar-card {
        background-color: #FAF7F2; /* Warna krem elegan senada dengan dropdown navbar */
        border-radius: 16px;
        border: 1px solid #E1DDD7;
        padding: 24px 20px;
        height: 100%;
    }
    
    .profile-menu-title {
        font-size: 12px;
        color: #8C7A6B;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 10px;
        margin-top: 24px;
        padding-left: 10px;
    }
    
    .profile-menu-title:first-child {
        margin-top: 0;
    }
    
    .profile-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #4A3F35;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        border-radius: 10px;
        transition: all 0.2s ease;
        margin-bottom: 4px;
    }
    
    .profile-link i {
        font-size: 20px;
        color: #8C7A6B; /* Warna ikon default */
        transition: color 0.2s ease;
    }
    
    /* Efek saat mouse diarahkan (Hover) */
    .profile-link:hover {
        background-color: #FFFFFF;
        color: #B8952E;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    
    .profile-link:hover i {
        color: #B8952E;
    }
    
    /* Efek saat menu sedang aktif / halaman sedang dibuka */
    .profile-link.active {
        background-color: #FFFFFF;
        color: #B8952E;
        font-weight: 600;
        border-left: 4px solid #B8952E;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    
    .profile-link.active i {
        color: #B8952E;
    }
</style>

<div class="col-md-3 mb-4 mb-md-0">
    <div class="profile-sidebar-card shadow-sm">
        
        <div class="profile-menu-title">Akun Saya</div>
        <div class="d-flex flex-column">
            <a href="{{ route('profile.index') }}" class="profile-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="bx bx-user"></i> Biodata Diri
            </a>
            
            <a href="{{ route('profile.addresses') ?? '#' }}" class="profile-link {{ request()->routeIs('profile.addresses*') ? 'active' : '' }}">
                <i class="bx bx-map-pin"></i> Buku Alamat
            </a>
            
            <a href="{{ route('profile.password') }}" class="profile-link {{ request()->routeIs('profile.password') ? 'active' : '' }}">
                <i class="bx bx-lock-alt"></i> Ubah Password
            </a>
        </div>

        <div class="profile-menu-title">Transaksi</div>
        <div class="d-flex flex-column">
            <a href="{{ route('profile.orders') }}" class="profile-link {{ request()->routeIs('profile.orders') ? 'active' : '' }}">
                <i class="bx bx-shopping-bag"></i> Riwayat Pesanan
            </a>
            
            <a href="{{ route('profile.wishlist') }}" class="profile-link {{ request()->routeIs('profile.wishlist') ? 'active' : '' }}">
                <i class="bx bx-heart"></i> Daftar Keinginan
            </a>
            
            <a href="{{ route('profile.reviews') }}" class="profile-link {{ request()->routeIs('profile.reviews') ? 'active' : '' }}">
                <i class="bx bx-star"></i> Ulasan Saya
            </a>
        </div>

        <div class="profile-menu-title">Promo</div>
        <div class="d-flex flex-column">
            <a href="{{ route('profile.vouchers') }}" class="profile-link {{ request()->routeIs('profile.vouchers') ? 'active' : '' }}">
                <i class="bx bx-purchase-tag-alt"></i> Voucher Saya
            </a>
        </div>

        <hr style="border-color: #D2C6B6; margin: 20px 0;">

        <div class="d-flex flex-column">
            <a href="#" onclick="confirmLogout(event, '{{ route('logout.gampang') }}')" class="profile-link text-danger" style="color: #DC3545 !important;">
                <i class="bx bx-log-out" style="color: #DC3545 !important;"></i> Keluar
            </a>
        </div>

    </div>
</div>