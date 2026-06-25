<div>
    <style>
        /* Smooth Entrance Animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .premium-page-bg {
            background-color: #f8fafc; /* Slate 50 */
            min-height: calc(100vh - 60px);
            padding-top: 2rem;
            padding-bottom: 4rem;
        }

        .premium-card {
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            /* Ultra-smooth layered shadow (Stripe style) */
            box-shadow: 0 2px 4px rgba(0,0,0,0.02), 
                        0 8px 16px rgba(0,0,0,0.03), 
                        0 16px 32px rgba(0,0,0,0.02);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
            position: relative;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
            opacity: 0; /* for animation */
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Animation Delays for Stagger Effect */
        .card-delay-1 { animation-delay: 0.1s; }
        .card-delay-2 { animation-delay: 0.15s; }
        .card-delay-3 { animation-delay: 0.2s; }
        .card-delay-4 { animation-delay: 0.25s; }
        .card-delay-5 { animation-delay: 0.3s; }
        .card-delay-6 { animation-delay: 0.35s; }
        .card-delay-7 { animation-delay: 0.4s; }
        .card-delay-8 { animation-delay: 0.45s; }

        .premium-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--card-accent, transparent);
            transition: height 0.3s ease;
            opacity: 0.9;
        }

        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.03), 
                        0 12px 24px rgba(0,0,0,0.05), 
                        0 24px 48px rgba(0,0,0,0.04);
            border-color: rgba(226, 232, 240, 1);
        }

        .premium-card:hover::after {
            height: 6px;
        }

        .premium-card .icon-box {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 1.5rem;
            background: linear-gradient(135deg, var(--icon-bg-start), var(--icon-bg-end));
            border: 1px solid var(--icon-border);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .premium-card:hover .icon-box {
            transform: scale(1.1) rotate(-5deg);
        }

        .premium-card .chevron-icon {
            transition: all 0.3s ease;
            color: #cbd5e1;
        }

        .premium-card:hover .chevron-icon {
            transform: translateX(8px);
            color: var(--card-accent) !important;
            opacity: 1 !important;
        }

        .premium-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.015em;
            margin-bottom: 0.25rem;
        }

        .premium-desc {
            font-size: 0.95rem;
            color: #64748b;
            font-weight: 500;
            line-height: 1.4;
        }
    </style>

    <div class="premium-page-bg">
        <div class="container-xl">
            
            <!-- Welcome Banner (Minimalist) -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 animation-fade-in" style="animation: fadeInUp 0.5s ease-out forwards;">
                <div>
                    <h2 class="fw-bolder text-dark mb-1" style="font-size: 1.8rem; letter-spacing: -0.5px;">Selamat datang, Administrator</h2>
                    <p class="text-muted mb-0" style="font-size: 1rem;">Pusat kendali operasional Gallery Puan.</p>
                </div>
                <div class="d-none d-md-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm mt-3 mt-md-0" style="border: 1px solid rgba(0,0,0,0.05);">
                    <span class="badge bg-success me-2" style="width: 8px; height: 8px; padding: 0; border-radius: 50%;"></span>
                    <span class="fw-semibold text-dark" style="font-size: 0.85rem;">Sistem Online</span>
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="row g-4 g-lg-5">
                
                <!-- Kategori -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/categories" wire:navigate class="premium-card card-delay-1" style="--card-accent: #1e3a8a; --icon-bg-start: rgba(30, 58, 138, 0.12); --icon-bg-end: rgba(30, 58, 138, 0.02); --icon-border: rgba(30, 58, 138, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#1e3a8a" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 4h6v6h-6z" />
                                    <path d="M14 4h6v6h-6z" />
                                    <path d="M4 14h6v6h-6z" />
                                    <circle cx="17" cy="17" r="3" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Kategori</div>
                                <div class="premium-desc">Kelola jenis hijab</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Produk -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/products" wire:navigate class="premium-card card-delay-2" style="--card-accent: #0f766e; --icon-bg-start: rgba(15, 118, 110, 0.12); --icon-bg-end: rgba(15, 118, 110, 0.02); --icon-border: rgba(15, 118, 110, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#0f766e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="6" y="5" width="12" height="14" rx="2" />
                                    <path d="M9 11a3 3 0 0 0 6 0" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Data Produk</div>
                                <div class="premium-desc">Daftar stok barang</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Layanan Chat -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/chat" wire:navigate class="premium-card card-delay-3" style="--card-accent: #334155; --icon-bg-start: rgba(51, 65, 85, 0.12); --icon-bg-end: rgba(51, 65, 85, 0.02); --icon-border: rgba(51, 65, 85, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#334155" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Layanan Chat</div>
                                <div class="premium-desc">Interaksi pelanggan</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Data Order -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/orders" wire:navigate class="premium-card card-delay-4" style="--card-accent: #b45309; --icon-bg-start: rgba(180, 83, 9, 0.12); --icon-bg-end: rgba(180, 83, 9, 0.02); --icon-border: rgba(180, 83, 9, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#b45309" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                                    <path d="M14 8h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5m2 0v1.5m0 -9v1.5" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Data Order</div>
                                <div class="premium-desc">Status transaksi pesanan</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Konsumen -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/customers" wire:navigate class="premium-card card-delay-5" style="--card-accent: #4338ca; --icon-bg-start: rgba(67, 56, 202, 0.12); --icon-bg-end: rgba(67, 56, 202, 0.02); --icon-border: rgba(67, 56, 202, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#4338ca" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Konsumen</div>
                                <div class="premium-desc">Basis data pelanggan</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Voucher Promo -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/vouchers" wire:navigate class="premium-card card-delay-6" style="--card-accent: #9f1239; --icon-bg-start: rgba(159, 18, 57, 0.12); --icon-bg-end: rgba(159, 18, 57, 0.02); --icon-border: rgba(159, 18, 57, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#9f1239" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="15" y1="5" x2="15" y2="7" />
                                    <line x1="15" y1="11" x2="15" y2="13" />
                                    <line x1="15" y1="17" x2="15" y2="19" />
                                    <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Voucher Promo</div>
                                <div class="premium-desc">Sistem kelola diskon</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Konten Web -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/settings" wire:navigate class="premium-card card-delay-7" style="--card-accent: #171717; --icon-bg-start: rgba(23, 23, 23, 0.12); --icon-bg-end: rgba(23, 23, 23, 0.02); --icon-border: rgba(23, 23, 23, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#171717" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 4h6v8h-6z" />
                                    <path d="M4 16h6v4h-6z" />
                                    <path d="M14 12h6v8h-6z" />
                                    <path d="M14 4h6v4h-6z" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Konten Web</div>
                                <div class="premium-desc">Pengaturan beranda</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Laporan -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/admin/reports" wire:navigate class="premium-card card-delay-8" style="--card-accent: #065f46; --icon-bg-start: rgba(6, 95, 70, 0.12); --icon-bg-end: rgba(6, 95, 70, 0.02); --icon-border: rgba(6, 95, 70, 0.15);">
                        <div class="card-body p-4 py-lg-5 px-lg-4 d-flex align-items-center h-100">
                            <div class="icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.8" stroke="#065f46" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="19" x2="20" y2="19" />
                                    <polyline points="4 15 8 9 12 11 16 6 20 10" />
                                </svg>
                            </div>
                            <div class="flex-fill">
                                <div class="premium-title">Laporan Analitik</div>
                                <div class="premium-desc">Metrik performa toko</div>
                            </div>
                            <div class="chevron-icon ms-2">
                                <i class="bx bx-chevron-right fs-1"></i>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>