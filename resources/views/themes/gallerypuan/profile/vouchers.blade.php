@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bx bx-purchase-tag-alt text-warning"></i> Voucher Saya</h2>
            <p class="text-muted">Gunakan promo spesial di bawah ini untuk mendapatkan potongan harga pada belanja kamu.</p>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            
            <h5 class="fw-bold mb-3" style="color: #4A3F35;">Voucher yang Bisa Dipakai</h5>
            <div class="row mb-5">
                @forelse ($availableVouchers as $voucher)
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border-left: 5px solid #4A3F35 !important;">
                            <div class="d-flex h-100">
                                <div class="p-3 d-flex flex-column justify-content-center align-items-center text-white" style="background-color: #B8952E; width: 35%; border-right: 2px dashed white;">
                                    <h4 class="fw-bold mb-0 text-center" style="font-size: 1.2rem;">
                                        @if($voucher->type == 'percent')
                                            {{ floatval($voucher->value) }}%
                                        @else
                                            Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                        @endif
                                    </h4>
                                    <span class="small text-white-50" style="font-size: 10px;">KODE PROMO</span>
                                </div>
                                <div class="p-3 d-flex flex-column justify-content-center bg-white" style="width: 65%;">
                                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-1">
                                        <div>
                                            <span class="badge bg-light text-dark border me-1">{{ $voucher->code }}</span>
                                            @if($voucher->is_first_order_only) 
                                                <span class="badge bg-opacity-10 text-luxury border border-secondary" style="font-size: 10px; background-color: #EFEBE7;">Pengguna Baru</span> 
                                            @endif
                                            @if($voucher->min_order_count > 0)
                                                <span class="badge bg-dark text-white" style="font-size: 10px;">Pesanan Ke-{{ $voucher->min_order_count }}</span>
                                            @endif
                                        </div>
                                        @if($voucher->expired_at)
                                            <small class="text-danger mt-1" style="font-size: 11px;">S/d {{ \Carbon\Carbon::parse($voucher->expired_at)->format('d M') }}</small>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold mb-1" style="color: #4A3F35;">{{ $voucher->description ?? 'Diskon Spesial' }}</h6>
                                    <p class="text-muted mb-2" style="font-size: 12px;">Min. Belanja: Rp {{ number_format($voucher->min_total, 0, ',', '.') }}</p>
                                    
                                    <a href="{{ url('/products') }}" class="btn btn-sm w-100 text-white mt-auto fw-bold" style="background-color: #8C7A6B; border-radius: 6px; padding: 8px 0;">
                                        Gunakan untuk Belanja
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 bg-light rounded" style="border: 1px dashed #ccc;">
                        <p class="text-muted mb-0">Belum ada voucher yang tersedia untuk Anda saat ini.</p>
                    </div>
                @endforelse
            </div>

            @if(count($lockedVouchers) > 0)
                <h5 class="fw-bold mb-3 text-muted"><i class="bx bx-lock-alt"></i> Voucher Terkunci</h5>
                <div class="row">
                    @foreach ($lockedVouchers as $voucher)
                        <div class="col-md-6 mb-3">
                            <div class="card border-0" style="border-radius: 12px; overflow: hidden; opacity: 0.6; filter: grayscale(100%); border-left: 5px solid #adb5bd !important;">
                                <div class="d-flex h-100">
                                    <div class="p-3 d-flex flex-column justify-content-center align-items-center bg-secondary text-white" style="width: 35%; border-right: 2px dashed white;">
                                        <i class="bx bx-lock fs-2 mb-1"></i>
                                    </div>
                                    <div class="p-3 bg-light d-flex flex-column" style="width: 65%;">
                                        <div class="mb-2">
                                            <span class="badge bg-white text-muted border me-1">{{ $voucher->code }}</span>
                                            @if($voucher->is_first_order_only) 
                                                <span class="badge border border-secondary text-muted" style="font-size: 10px;">Pengguna Baru</span> 
                                            @endif
                                            @if($voucher->min_order_count > 0)
                                                <span class="badge bg-secondary text-white" style="font-size: 10px;">Pesanan Ke-{{ $voucher->min_order_count }}</span>
                                            @endif
                                        </div>
                                        <h6 class="fw-bold text-muted mb-1">{{ $voucher->description ?? 'Voucher Spesial' }}</h6>
                                        <p class="text-muted mb-2" style="font-size: 12px;">Min. Belanja: Rp {{ number_format($voucher->min_total, 0, ',', '.') }}</p>
                                        
                                        <div class="mt-auto pt-2 border-top text-danger fw-medium" style="font-size: 11px;">
                                            <i class='bx bxs-lock-alt me-1'></i> {{ $voucher->reason }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection