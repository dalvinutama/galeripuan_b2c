<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Pengajuan Retur</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn {{ $filterStatus === '' ? 'btn-primary' : 'btn-white' }}" wire:click="$set('filterStatus', '')">Semua</button>
                        <button class="btn {{ $filterStatus === 'PENDING' ? 'btn-warning' : 'btn-white' }}" wire:click="$set('filterStatus', 'PENDING')">Pending</button>
                        <button class="btn {{ $filterStatus === 'APPROVED' ? 'btn-success' : 'btn-white' }}" wire:click="$set('filterStatus', 'APPROVED')">Disetujui</button>
                        <button class="btn {{ $filterStatus === 'REJECTED' ? 'btn-danger' : 'btn-white' }}" wire:click="$set('filterStatus', 'REJECTED')">Ditolak</button>
                    </div>
                </div>

                <div class="card-body p-0">
                    @forelse ($claims as $claim)
                    <div class="border-bottom" style="transition: all 0.2s;">
                        <div class="p-3 d-flex flex-wrap align-items-start gap-3">
                            <div class="flex-grow-1" style="min-width: 200px;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="fw-bold text-primary" style="font-size: 15px;">{{ $claim->order->code ?? '-' }}</span>
                                    <span class="badge bg-secondary text-white" style="font-size: 10px;">{{ $claim->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    <span class="fw-semibold">{{ $claim->user->name ?? '-' }}</span>
                                    <span class="text-muted" style="font-size: 12px;">{{ $claim->user->email ?? '' }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                @switch($claim->status)
                                    @case('PENDING')
                                        <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 12px;">Pending</span>
                                        @break
                                    @case('APPROVED')
                                        <span class="badge bg-success px-3 py-2" style="font-size: 12px;">Disetujui</span>
                                        @break
                                    @case('REJECTED')
                                        <span class="badge bg-danger px-3 py-2" style="font-size: 12px;">Ditolak</span>
                                        @break
                                @endswitch
                            </div>
                        </div>

                        <div class="px-3 pb-3">
                            <div class="bg-light rounded p-3 mb-3" style="border-left: 4px solid {{ $claim->status === 'APPROVED' ? '#2fb344' : ($claim->status === 'REJECTED' ? '#d63939' : '#f59f00') }};">
                                <div class="d-flex gap-3 flex-wrap align-items-start">
                                    <div class="flex-grow-1" style="min-width: 150px;">
                                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Alasan Retur</small>
                                        <p class="mb-0 mt-1" style="font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $claim->reason }}</p>
                                    </div>
                                    @if($claim->proof_image)
                                    <div style="flex-shrink: 0;">
                                        <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Bukti Foto</small>
                                        <img src="{{ asset('storage/' . $claim->proof_image) }}"
                                             alt="Bukti retur"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 1px solid #dee2e6;"
                                             wire:click="previewImage('{{ asset('storage/' . $claim->proof_image) }}')">
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if($claim->status === 'PENDING')
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-sm btn-success px-3" wire:click="approve('{{ $claim->id }}')" onclick="return confirm('Setujui retur ini?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1" style="vertical-align: text-top;"><path d="M5 12l5 5l10 -10"/></svg>
                                    Setujui
                                </button>
                                <button class="btn btn-sm btn-danger px-3" wire:click="reject('{{ $claim->id }}')" onclick="return confirm('Tolak retur ini?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1" style="vertical-align: text-top;"><path d="M18 6l-12 12"/><path d="M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-3 text-muted opacity-50"><path d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6z"/><path d="M3 16l5-5c.928-.893 2.072-.893 3 0l5 5"/><path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/></svg>
                        <p class="mb-0 fw-semibold">Belum ada pengajuan retur.</p>
                    </div>
                    @endforelse
                </div>

                @if($claims->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $claims->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Preview Foto --}}
    @if($showImageModal)
    <div class="modal show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.7);" wire:click.self="closeModal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
                <div class="modal-header border-0 pb-0" style="position: absolute; top: 8px; right: 8px; z-index: 10;">
                    <button type="button" class="btn btn-sm btn-dark rounded-circle" style="width: 36px; height: 36px;" wire:click="closeModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6l-12 12"/><path d="M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="{{ $previewImageUrl }}" alt="Bukti retur" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
