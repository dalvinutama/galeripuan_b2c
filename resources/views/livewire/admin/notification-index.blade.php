<div>
    <div class="page-header d-print-none mb-4">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle text-uppercase font-weight-bold text-muted" style="letter-spacing: 2px; font-size: 11px;">
                        Pusat Kendali
                    </div>
                    <h2 class="page-title text-dark display-6 fw-bolder mt-1">
                        Pemberitahuan Sistem
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button wire:click="markAllAsRead" class="btn btn-primary shadow-sm rounded-pill px-4 fw-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checks" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                            Tandai Semua Dibaca
                        </button>
                        <button wire:click="deleteAllRead" onclick="confirm('Yakin ingin menghapus seluruh riwayat notifikasi yang sudah dibaca?') || event.stopImmediatePropagation()" class="btn btn-outline-danger shadow-sm rounded-pill px-4 fw-medium ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h16" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>
                            Bersihkan Riwayat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    
                    @forelse ($notifications as $notif)
                        @php
                            $isUnread = is_null($notif->read_at);
                            $title = $notif->data['title'] ?? 'Notifikasi';
                            $message = $notif->data['message'] ?? '';
                            $url = $notif->data['url'] ?? '#';
                            
                            // Tentukan Icon & Warna Berdasarkan Keyword
                            if (str_contains(strtolower($title), 'gagal') || str_contains(strtolower($title), 'habis')) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>';
                                $colorClass = 'text-danger bg-danger-lt';
                                $borderClass = 'border-danger';
                            } elseif (str_contains(strtolower($title), 'pesanan')) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /></svg>';
                                $colorClass = 'text-azure bg-azure-lt';
                                $borderClass = 'border-azure';
                            } elseif (str_contains(strtolower($title), 'peringatan') || str_contains(strtolower($title), 'menipis') || str_contains(strtolower($title), 'kedaluwarsa')) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>';
                                $colorClass = 'text-warning bg-warning-lt';
                                $borderClass = 'border-warning';
                            } elseif (str_contains(strtolower($title), 'ulasan')) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>';
                                $colorClass = 'text-yellow bg-yellow-lt';
                                $borderClass = 'border-yellow';
                            } elseif (str_contains(strtolower($title), 'login') || str_contains(strtolower($title), 'keamanan')) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /><path d="M12 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 12l0 2.5" /></svg>';
                                $colorClass = 'text-indigo bg-indigo-lt';
                                $borderClass = 'border-indigo';
                            } elseif (str_contains(strtolower($title), 'pesan')) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>';
                                $colorClass = 'text-teal bg-teal-lt';
                                $borderClass = 'border-teal';
                            } else {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>';
                                $colorClass = 'text-blue bg-blue-lt';
                                $borderClass = 'border-blue';
                            }

                            // Styling khusus Unread vs Read
                            $cardClass = $isUnread ? 'bg-white border ' . $borderClass . ' notif-card-unread' : 'border opacity-75 hover-reveal notif-card-read';
                            $titleClass = $isUnread ? 'fw-bolder fs-3' : 'fw-bold fs-3';
                            $messageClass = $isUnread ? 'fw-bold fs-4' : 'fw-semibold fs-4';
                        @endphp
                        
                        <div class="card mb-3 {{ $cardClass }} rounded-3 overflow-hidden notif-card">
                            <div class="card-body p-3 p-md-4">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-md rounded-circle {{ $colorClass }} shadow-sm">
                                            {!! $icon !!}
                                        </div>
                                    </div>
                                    <div class="col ps-2">
                                        <a href="#" wire:click.prevent="markAsRead('{{ $notif->id }}')" class="text-decoration-none d-block">
                                            <div class="d-flex align-items-center mb-1">
                                                <h3 class="{{ $titleClass }} mb-0" style="letter-spacing: -0.02em; color: #000000 !important;">
                                                    {{ $title }}
                                                </h3>
                                                @if($isUnread)
                                                    <span class="badge bg-red text-red-fg ms-2 px-2 py-1 rounded-pill fw-bold" style="font-size: 11px; animation: pulse 2s infinite;">BARU</span>
                                                @endif
                                            </div>
                                            <p class="mb-0 {{ $messageClass }}" style="line-height: 1.6; max-width: 95%; color: #000000 !important;">
                                                {{ $message }}
                                            </p>
                                        </a>
                                    </div>
                                    <div class="col-auto text-end d-flex flex-column justify-content-center align-items-end" style="min-width: 140px;">
                                        <span class="d-block fw-bold mb-1 fs-4" style="color: #000000 !important;">
                                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                        </span>
                                        <span class="fw-bold d-block mb-3" style="font-size: 12px; color: #000000 !important;">
                                            {{ \Carbon\Carbon::parse($notif->created_at)->format('d M Y • H:i') }}
                                        </span>
                                        @if(!$isUnread)
                                            <button wire:click.prevent="deleteNotification('{{ $notif->id }}')" class="btn btn-sm btn-light text-danger btn-icon rounded-pill shadow-sm hover-danger" title="Hapus Permanen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h16" /><path d="M10 11v6" /><path d="M14 11v6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty bg-white rounded-3 shadow-sm py-5 mt-4 border">
                            <div class="empty-img mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="80" height="80" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                            </div>
                            <p class="empty-title display-6 fw-bold text-dark">Semua Bersih!</p>
                            <p class="empty-subtitle text-secondary fs-4">
                                Saat ini kotak masuk notifikasi Anda masih kosong. Nikmati harimu!
                            </p>
                        </div>
                    @endforelse

                    @if($notifications->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(214, 57, 57, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(214, 57, 57, 0); }
            100% { box-shadow: 0 0 0 0 rgba(214, 57, 57, 0); }
        }
        
        .notif-card {
            transition: all 0.25s cubic-bezier(0.02, 0.01, 0.47, 1);
            border-width: 2px !important;
            margin-bottom: 1.25rem !important; /* Jarak antar card dilebarkan sedikit */
        }
        
        .notif-card-unread {
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            border-left-width: 6px !important; /* Garis kiri super tebal untuk unread */
        }

        .notif-card-read {
            border-color: #cbd5e1 !important; /* Warna abu-abu tegas untuk border read */
            background-color: #f8fafc !important; /* Latar belakang sedikit kontras */
        }

        .notif-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(0,0,0,0.15) !important;
            border-color: #94a3b8 !important; /* Garis hover lebih gelap */
        }

        .hover-reveal {
            transition: opacity 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }
        
        .hover-reveal:hover {
            opacity: 1 !important;
            background-color: #ffffff !important;
        }

        .hover-danger:hover {
            background-color: #d63939 !important;
            color: white !important;
        }

        /* Warna Light Transparan untuk Background Icon */
        .bg-danger-lt { background: rgba(214, 57, 57, 0.12) !important; color: #d63939 !important; }
        .bg-azure-lt { background: rgba(66, 153, 225, 0.12) !important; color: #4299e1 !important; }
        .bg-warning-lt { background: rgba(245, 159, 0, 0.12) !important; color: #f59f00 !important; }
        .bg-yellow-lt { background: rgba(245, 159, 0, 0.12) !important; color: #f59f00 !important; }
        .bg-indigo-lt { background: rgba(66, 99, 235, 0.12) !important; color: #4263eb !important; }
        .bg-teal-lt { background: rgba(9, 146, 104, 0.12) !important; color: #099268 !important; }
        .bg-blue-lt { background: rgba(32, 107, 196, 0.12) !important; color: #206bc4 !important; }
    </style>
</div>
