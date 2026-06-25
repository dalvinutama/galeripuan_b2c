<div class="nav-item dropdown d-none d-md-flex me-3 ms-2" wire:poll.30s="refreshNotifs">
    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-dark" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
        </svg>
        @if ($totalUnread > 0)
            <span class="badge bg-red badge-blink">{{ $unreadCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card shadow-sm border-0" style="width: 350px;">
        <div class="card border-0">
            <div class="card-header bg-primary text-white border-0 d-flex align-items-center justify-content-between">
                <h3 class="card-title fw-bold text-white mb-0">Notifikasi Terbaru</h3>
                @if ($totalUnread > 0)
                    <button wire:click="markAllAsRead" class="btn btn-sm btn-outline-light text-white border-white py-0" style="font-size: 11px;">
                        Tandai Dibaca
                    </button>
                @endif
            </div>
            <div class="list-group list-group-flush list-group-hoverable" style="max-height: 350px; overflow-y: auto;">
                @php
                    $unreadNotifs = array_filter($notifications, fn($n) => is_null($n['read_at']));
                    $readNotifs = array_filter($notifications, fn($n) => !is_null($n['read_at']));
                @endphp

                @if(count($unreadNotifs) > 0)
                    <div class="list-group-header sticky-top bg-light py-1 px-3 small fw-bold text-muted border-bottom">Belum Dibaca</div>
                    @foreach ($unreadNotifs as $notif)
                        @php
                            $dotClass = match(true) {
                                str_contains($notif['data']['title'] ?? '', 'Gagal') || str_contains($notif['data']['title'] ?? '', 'Habis') => 'bg-red',
                                str_contains($notif['data']['title'] ?? '', 'Menipis') || str_contains($notif['data']['title'] ?? '', 'Peringatan') => 'bg-warning',
                                str_contains($notif['data']['title'] ?? '', 'Baru') || str_contains($notif['data']['title'] ?? '', 'Baru Dibayar') => 'bg-green',
                                default => 'bg-blue',
                            };
                            $notifUrl = $notif['data']['url'] ?? '#';
                            $notifTitle = $notif['data']['title'] ?? 'Notifikasi';
                            $notifMessage = $notif['data']['message'] ?? '';
                        @endphp
                        <a href="{{ $notifUrl }}" class="list-group-item list-group-item-action bg-azure-lt" wire:click.prevent="markAsRead('{{ $notif['id'] }}')" wire:key="notif-{{ $notif['id'] }}">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="status-dot {{ $dotClass }} d-block status-dot-animated"></span>
                                </div>
                                <div class="col text-truncate">
                                    <strong class="text-body d-block fw-bold">{{ $notifTitle }}</strong>
                                    <div class="d-block text-secondary text-truncate mt-n1 small text-dark">
                                        {{ $notifMessage }}
                                    </div>
                                    <div class="d-block text-muted mt-n1" style="font-size: 10px;">
                                        {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif

                @if(count($readNotifs) > 0)
                    <div class="list-group-header sticky-top bg-light py-1 px-3 small fw-bold text-muted border-bottom border-top">Sebelumnya</div>
                    @foreach ($readNotifs as $notif)
                        @php
                            $notifUrl = $notif['data']['url'] ?? '#';
                            $notifTitle = $notif['data']['title'] ?? 'Notifikasi';
                            $notifMessage = $notif['data']['message'] ?? '';
                        @endphp
                        <a href="{{ $notifUrl }}" class="list-group-item list-group-item-action opacity-75" wire:key="notif-{{ $notif['id'] }}">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="status-dot bg-secondary d-block"></span>
                                </div>
                                <div class="col text-truncate">
                                    <strong class="text-body d-block fw-normal">{{ $notifTitle }}</strong>
                                    <div class="d-block text-secondary text-truncate mt-n1 small">
                                        {{ $notifMessage }}
                                    </div>
                                    <div class="d-block text-muted mt-n1" style="font-size: 10px;">
                                        {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif

                @if(empty($notifications))
                    <div class="list-group-item text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-muted" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                        </svg>
                        <p class="text-muted mb-0">Belum ada notifikasi baru.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer text-center border-0 py-2">
                <a href="/admin/notifications" class="btn btn-link btn-sm text-muted">Lihat Semua Notifikasi</a>
            </div>
        </div>
    </div>
</div>
