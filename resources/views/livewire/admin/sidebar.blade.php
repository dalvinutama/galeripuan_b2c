<style>
    /* Styling Sidebar Admin - VVIP Luxury Level */
    
    /* 1. Fading Gold Divider untuk Menu Utama */
    .admin-sidebar-menu .nav-item {
        position: relative;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border: none !important;
    }
    .admin-sidebar-menu .nav-item::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 5%;
        width: 90%;
        height: 1px;
        background: linear-gradient(90deg, rgba(197,160,89,0) 0%, rgba(197,160,89,0.6) 50%, rgba(197,160,89,0) 100%);
    }
    .admin-sidebar-menu .nav-item:last-child::after { display: none; }
    
    /* 2. Tipografi Mewah Menu Utama */
    .admin-sidebar-menu .nav-link-title {
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 13px;
        font-weight: 700;
        color: #F3EBE1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .admin-sidebar-menu .nav-link-icon svg,
    .admin-sidebar-menu .nav-link-icon i {
        color: #C5A059 !important;
        transition: all 0.3s ease;
    }
    
    /* 3. Fading Tipis untuk Sub-menu */
    .admin-sidebar-menu .dropdown-item {
        position: relative;
        padding: 12px 18px;
        margin-bottom: 4px;
        color: #9CA3AF;
        font-size: 13.5px;
        letter-spacing: 0.8px;
        border: none !important;
    }
    .admin-sidebar-menu .dropdown-item::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 10%;
        width: 80%;
        height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0) 100%);
    }
    .admin-sidebar-menu .dropdown-item:last-child::after { display: none; }

    /* 4. Efek Interaktif (Hover) yang Hidup */
    .admin-sidebar-menu .nav-link, .admin-sidebar-menu .dropdown-item {
        border-radius: 8px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .admin-sidebar-menu .nav-item > .nav-link:hover {
        background: linear-gradient(90deg, rgba(197,160,89,0.15) 0%, transparent 100%);
        color: #fff;
    }

    .admin-sidebar-menu .dropdown-item:hover {
        background: linear-gradient(90deg, rgba(255,255,255,0.06) 0%, transparent 100%);
        transform: translateX(10px); 
        color: #C5A059;
    }

    /* 5. State Aktif dengan Glow Effect (Sangat Premium) */
    .admin-sidebar-menu .dropdown-item.active {
        background: linear-gradient(90deg, rgba(197,160,89,0.25) 0%, transparent 100%) !important;
        border-left: 4px solid #C5A059 !important;
        color: #FFFFFF !important;
        font-weight: 800;
        text-shadow: 0 0 15px rgba(255,255,255,0.4);
    }
    
    .admin-sidebar-menu .nav-item.active > .nav-link {
        background: linear-gradient(90deg, rgba(197,160,89,0.15) 0%, transparent 100%);
    }
    .admin-sidebar-menu .nav-item.active > .nav-link .nav-link-icon svg {
        filter: drop-shadow(0px 0px 6px rgba(197,160,89,0.9));
        transform: scale(1.1);
    }
</style>
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="/admin/dashboard" wire:navigate>
                @php
                    $siteLogo = \App\Models\Setting::getValue('site_logo', 'themes/gallerypuan/assets/img/logo.jpg');
                @endphp
                <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset($siteLogo) }}" alt="Logo Toko" width="45" height="45" class="rounded-circle" style="object-fit: cover;">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-lg-flex me-3">
                <div class="btn-list">
                    <a href="https://github.com/tabler/tabler" class="btn" target="_blank" rel="noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
                        </svg>
                        Source code
                    </a>
                    <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank" rel="noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                        </svg>
                        Sponsor
                    </a>
                </div>
            </div>
            <div class="d-none d-lg-flex">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
                    data-bs-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
                    data-bs-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </a>
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                        </svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Last updates</h3>
                            </div>
                            <div class="list-group list-group-flush list-group-hoverable">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">System Update</a>
                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                Update successfully applied.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>Admin Gallery Puan</div>
                        <div class="mt-1 small text-secondary">Administrator</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="./profile.html" class="dropdown-item">Profile</a>
                    <a href="./settings.html" class="dropdown-item">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a href="./sign-in.html" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3 admin-sidebar-menu">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="/admin/dashboard" wire:navigate>
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Home
                        </span>
                    </a>
                </li>


                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Catalog
                        </span>
                    </a>
                    <div class="dropdown-menu show" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is('admin/categories*') ? 'active' : '' }}" href="/admin/categories" wire:navigate>
                                    Kategori
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/products*') ? 'active' : '' }}" href="/admin/products" wire:navigate>
                                    Produk
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/chat') ? 'active' : '' }}" href="/admin/chat" wire:navigate>
                                    Layanan Chat
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/chat/settings') ? 'active' : '' }}" href="/admin/chat/settings" wire:navigate>
                                    <i class='bx bx-cog me-1' style="font-size: 14px;"></i> Pengaturan Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-manage" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17h-11v-14h-2" />
                                <path d="M6 5l14 1l-1 7h-13" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Manage
                        </span>
                    </a>
                    <div class="dropdown-menu show" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is('admin/orders*') ? 'active' : '' }}" href="/admin/orders" wire:navigate>
                                    Order
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/customers*') ? 'active fw-bold' : '' }}" href="/admin/customers" wire:navigate>
                                    Data Konsumen
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/vouchers*') ? 'active fw-bold' : '' }}" href="/admin/vouchers" wire:navigate>
                                    Voucher
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/returns*') ? 'active fw-bold' : '' }}" href="/admin/returns" wire:navigate>
                                    Retur & Klaim
                                </a>
                                <a class="dropdown-item {{ request()->is('admin/settings*') ? 'active' : '' }}" href="/admin/settings" wire:navigate>
                                    Konten Homepage
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-report" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                                <path d="M18 14v4h4" />
                                <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" />
                                <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M8 11h4" />
                                <path d="M8 15h3" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Laporan
                        </span>
                    </a>
                    <div class="dropdown-menu show" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is('admin/reports*') ? 'active' : '' }}" href="/admin/reports" wire:navigate>
                                    Laporan Penjualan
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <a class="nav-link" href="/admin/profile" wire:navigate>
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class='bx bx-user-circle' style="font-size: 24px;"></i>
                        </span>
                        <span class="nav-link-title">
                            Profil Admin
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
