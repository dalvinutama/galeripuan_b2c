@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5 mb-5" style="background-color: #FFFFFF;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <a href="{{ route('orders.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block fw-bold">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar Pesanan
            </a>

@php
    $returnClaim = $order->returnClaim ?? null;
    $returLabel = match(true) {
        $returnClaim && $returnClaim->status === 'PENDING' => ['Retur Sedang Diproses', 'bg-warning text-dark', 'bx-time-five'],
        $returnClaim && $returnClaim->status === 'APPROVED' => ['Retur Disetujui', 'bg-success text-white', 'bx-check-shield'],
        $returnClaim && $returnClaim->status === 'REJECTED' => ['Retur Ditolak', 'bg-danger text-white', 'bx-x-circle'],
        default => null,
    };

                // Kamus Terjemahan Status
                $terjemahanPesanan = [
                    'created' => 'Pesanan Dibuat',
                    'processing' => 'Sedang Diproses',
                    'packaging' => 'Sedang Dikemas',
                    'shipped' => 'Sedang Dikirim',
                    'delivered' => 'Sedang Dikirim',
                    'completed' => 'Pesanan Selesai',
                    'received' => 'Pesanan Selesai',
                    'cancelled' => 'Pesanan Dibatalkan'
                ];

                $terjemahanPembayaran = [
                    'unpaid' => 'Belum Dibayar',
                    'paid' => 'Pembayaran Lunas',
                    'pending' => 'Menunggu Pembayaran',
                    'failed' => 'Pembayaran Gagal',
                    'expired' => 'Pembayaran Kedaluwarsa'
                ];

                $isExpired = \Carbon\Carbon::parse($order->created_at)->addHours(24)->isPast();
                $isUnpaid = in_array(strtolower($order->payment_status), ['unpaid', 'pending', 'created']);

                $statusPesananIndo = $terjemahanPesanan[strtolower($order->status)] ?? strtoupper($order->status);
                $statusPembayaranIndo = $terjemahanPembayaran[strtolower($order->payment_status)] ?? strtoupper($order->payment_status);

                if ($isUnpaid && $isExpired) {
                    $statusPesananIndo = 'Dibatalkan (Waktu Habis)';
                    $statusPembayaranIndo = 'Kedaluwarsa';
                }
            @endphp

            <div class="card shadow-sm mb-4 bg-white" style="border-radius: 16px; border: 1.5px solid #C4B9B1; overflow: hidden;">
                @if($isUnpaid && $isExpired)
                    <div class="bg-danger text-white px-4 py-3 d-flex align-items-center gap-3" style="border-bottom: 1.5px solid #C4B9B1;">
                        <i class="bx bx-x-circle fs-1"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Pesanan Kedaluwarsa</h5>
                            <small class="opacity-75">Waktu pembayaran 24 jam telah habis.</small>
                        </div>
                    </div>
                @elseif($isUnpaid)
                    <div class="bg-warning text-dark px-4 py-3 d-flex align-items-center gap-3" style="border-bottom: 1.5px solid #C4B9B1;">
                        <i class="bx bx-time-five fs-1"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Menunggu Pembayaran</h5>
                            <small class="opacity-75">Selesaikan pembayaran sebelum waktu habis.</small>
                        </div>
                    </div>
                @elseif(in_array(strtolower($order->status), ['delivered', 'shipped']))
                    <div class="px-4 py-3 d-flex align-items-center gap-3 text-white" style="background-color: #2b7a78; border-bottom: 1.5px solid #C4B9B1;">
                        <i class="bx bx-package fs-1"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Paket Dalam Perjalanan</h5>
                            <small class="opacity-75">Pesanan Anda sedang diantar oleh kurir.</small>
                        </div>
                    </div>
                @elseif(in_array(strtolower($order->status), ['completed', 'received']))
                    <div class="bg-success text-white px-4 py-3 d-flex align-items-center gap-3" style="border-bottom: 1.5px solid #C4B9B1;">
                        <i class="bx bx-check-shield fs-1"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Pesanan Selesai</h5>
                            <small class="opacity-75">Terima kasih telah berbelanja di Gallery Puan!</small>
                        </div>
                    </div>
                @else
                    <div class="px-4 py-3 d-flex align-items-center gap-3 text-white" style="background-color: #B8952E; border-bottom: 1.5px solid #C4B9B1;">
                        <i class="bx bx-cog fs-1"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $statusPesananIndo }}</h5>
                            <small class="opacity-75">Pesanan Anda sedang kami siapkan.</small>
                        </div>
                    </div>
                @endif

                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-1 fw-bold">Total Belanja</p>
                    <h2 class="fw-bold mb-4" style="color: #4A3F35;">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</h2>

                    @if($isUnpaid && !$isExpired && isset($payment->token))
                        <div class="d-flex flex-column gap-3">
                            <button id="pay-button" class="btn btn-success btn-lg w-100 fw-bold rounded-pill shadow-sm" style="border: 2px solid #198754;">
                                <i class="bx bx-wallet me-1"></i> Bayar Sekarang
                            </button>
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="confirmLuxury(event, this, 'Batalkan Pesanan', 'Apakah Anda yakin ingin membatalkan pesanan ini?', 'trash')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-lg w-100 fw-bold rounded-pill bg-white shadow-sm" style="border: 2px solid #DC3545;">
                                    <i class="bx bx-x-circle me-1"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @elseif($isUnpaid && $isExpired)
                        <button class="btn btn-light btn-lg w-100 fw-bold rounded-pill text-muted" disabled style="border: 2px solid #C4B9B1;">
                            Transaksi Ditutup
                        </button>
                    @elseif(in_array(strtolower($order->status), ['delivered', 'shipped']))
                        <form action="{{ route('orders.complete', $order->id) }}" method="POST" onsubmit="confirmLuxury(event, this, 'Selesaikan Pesanan', 'Apakah Anda yakin paket sudah diterima dengan baik?', 'check')">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold text-dark rounded-pill shadow-sm" style="border: 2px solid #ffc107;">
                                <i class="bx bx-check-double me-1"></i> Konfirmasi Pesanan Diterima
                            </button>
                        </form>
                    @elseif(in_array(strtolower($order->status), ['completed', 'received']))
                        @php
                            $canReturn = \Carbon\Carbon::parse($order->updated_at)->addDays(3)->isFuture();
                        @endphp
                        <div class="d-flex flex-column gap-3">
                            <a href="{{ route('profile.reviews') }}" class="btn btn-outline-success btn-lg w-100 fw-bold rounded-pill" style="border: 2px solid #198754;">
                                <i class="bx bx-star me-1"></i> Nilai Produk
                            </a>
                            @if($canReturn && !$returnClaim)
                                <a href="{{ route('returns.create', $order->id) }}" class="btn btn-outline-warning btn-lg w-100 fw-bold rounded-pill" style="border: 2px solid #ffc107;">
                                    <i class="bx bx-undo me-1"></i> Ajukan Retur / Klaim Cacat
                                </a>
                            @elseif($returnClaim)
                                @php
                                    $returLabel = match($returnClaim->status) {
                                        'PENDING' => ['Retur Sedang Diproses', 'bg-warning text-dark', 'bx-time-five'],
                                        'APPROVED' => ['Retur Disetujui', 'bg-success text-white', 'bx-check-shield'],
                                        'REJECTED' => ['Retur Ditolak', 'bg-danger text-white', 'bx-x-circle'],
                                        default => ['Retur', 'bg-secondary text-white', 'bx-info-circle'],
                                    };
                                @endphp
                                <span class="badge {{ $returLabel[1] }} py-2 px-3 fw-bold d-flex align-items-center justify-content-center gap-2" style="font-size: 14px;">
                                    <i class="bx {{ $returLabel[2] }}"></i> {{ $returLabel[0] }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-4 bg-white" style="border-radius: 16px; border: 1.5px solid #C4B9B1;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #4A3F35;"><i class="bx bx-map-pin text-warning me-2"></i>Informasi Pengiriman</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-bold small">No. Pesanan</div>
                        <div class="col-sm-8 fw-bold text-primary">{{ $order->code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-bold small">Penerima</div>
                        <div class="col-sm-8 fw-bold">{{ $order->customer_first_name }} {{ $order->customer_last_name }} <br> <span class="fw-normal text-muted">{{ $order->customer_phone }}</span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-bold small">Alamat</div>
                        <div class="col-sm-8 text-dark fw-medium">{{ $order->customer_address1 }}</div>
                    </div>
                    
                    <hr style="border-top: 1.5px solid #C4B9B1; opacity: 1; margin: 1.5rem 0;">
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-bold small">Kurir</div>
                        <div class="col-sm-8 fw-bold text-uppercase text-dark">{{ $order->shipping_courier }} ({{ $order->shipping_service_name }})</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-muted fw-bold small">No. Resi</div>
                        <div class="col-sm-8">
                            @if($order->shipping_number)
                                <span class="fw-bold fs-6 text-dark">{{ $order->shipping_number }}</span>
                                <a href="https://cekresi.com/?noresi={{ $order->shipping_number }}" target="_blank" class="badge bg-primary text-decoration-none ms-2 px-2 py-1 rounded-pill"><i class="bx bx-search-alt-2"></i> Lacak</a>
                            @else
                                <span class="text-muted fw-bold fst-italic">Belum diinput admin</span>
                            @endif
                        </div>
                    </div>

                    @if($returnClaim)
                    <hr style="border-top: 1.5px solid #C4B9B1; opacity: 1; margin: 1.5rem 0;">
                    <div>
                        <h5 class="fw-bold mb-3" style="color: #4A3F35;">
                            <i class="bx bx-undo text-warning me-2"></i>Status Retur
                        </h5>
                        <div class="bg-light rounded p-3" style="border-left: 4px solid {{ $returnClaim->status === 'APPROVED' ? '#198754' : ($returnClaim->status === 'REJECTED' ? '#dc3545' : '#ffc107') }};">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge {{ $returLabel[1] }} py-2 px-3 fw-bold" style="font-size: 13px;">
                                    <i class="bx {{ $returLabel[2] }} me-1"></i>{{ $returLabel[0] }}
                                </span>
                            </div>
                            <p class="mb-1 text-dark" style="font-size: 14px; white-space: pre-wrap;">{{ $returnClaim->reason }}</p>
                            @if($returnClaim->proof_image)
                                <a href="{{ asset('storage/' . $returnClaim->proof_image) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                                    <i class="bx bx-image me-1"></i> Lihat Foto Bukti
                                </a>
                            @endif
                            @if($returnClaim->status === 'APPROVED' && $returnClaim->approved_at)
                                <div class="mt-2 text-muted" style="font-size: 12px;">
                                    <i class="bx bx-check-circle text-success me-1"></i> Disetujui pada {{ \Carbon\Carbon::parse($returnClaim->approved_at)->format('d M Y H:i') }}
                                </div>
                            @endif
                            @if($returnClaim->status === 'REJECTED' && $returnClaim->rejected_at)
                                <div class="mt-2 text-muted" style="font-size: 12px;">
                                    <i class="bx bx-x-circle text-danger me-1"></i> Ditolak pada {{ \Carbon\Carbon::parse($returnClaim->rejected_at)->format('d M Y H:i') }}
                                </div>
                            @endif
                            @if($returnClaim->admin_note)
                                <div class="mt-2 p-2 bg-white rounded" style="font-size: 13px; border: 1px solid #dee2e6;">
                                    <small class="text-muted fw-bold">Catatan Admin:</small>
                                    <p class="mb-0 mt-1">{{ $returnClaim->admin_note }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm bg-white" style="border-radius: 16px; border: 1.5px solid #C4B9B1;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #4A3F35;"><i class="bx bx-receipt text-warning me-2"></i>Rincian Pesanan</h5>
                    
                    @if(isset($orderItems) || isset($order->items))
                        @foreach($orderItems ?? $order->items as $item)
                        @php
                            $prod = \Modules\Shop\Entities\Product::find($item->product_id);
                            $parentProd = $prod && $prod->parent_id ? $prod->parent : null;
                            $productImageObj = null;
                            if($prod) {
                                $productImageObj = $prod->images->first() ?? ($parentProd ? $parentProd->images->first() : null);
                            }
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1.5px solid #E1DDD7;">
                            <div class="d-flex align-items-center">
                                <img src="{{ shop_product_image($productImageObj) }}" alt="{{ $item->product_name ?? $item->name }}" class="me-3 rounded border" style="width: 48px; height: 48px; object-fit: cover;">
                                <div>
                                    <p class="fw-bold mb-0 text-dark">{{ $item->product_name ?? $item->name }}</p>
                                    @if($item->attributes && is_array($item->attributes) && count($item->attributes) > 0)
                                        <div class="text-muted" style="font-size: 11px; margin-bottom: 2px;">
                                            @foreach($item->attributes as $key => $val)
                                                <span class="me-2">{{ ucfirst($key == 'color' ? 'Warna' : $key) }}: <span class="fw-semibold">{{ $val }}</span></span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <small class="text-muted fw-bold">{{ $item->qty }} x Rp {{ number_format($item->base_price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                            <div class="fw-bold text-dark">
                                Rp {{ number_format($item->qty * $item->base_price, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    @endif

                    <div class="row mt-4">
                        <div class="col-6 text-muted fw-bold">Subtotal Produk</div>
                        <div class="col-6 text-end fw-bold text-dark">Rp {{ number_format($order->base_total_price, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 text-muted fw-bold">Ongkos Kirim</div>
                        <div class="col-6 text-end fw-bold text-dark">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
                    </div>
                    
                    @if($order->discount_amount > 0)
                    <div class="row mt-2">
                        <div class="col-6 fw-bold text-danger">Diskon / Voucher</div>
                        <div class="col-6 text-end fw-bold text-danger">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</div>
                    </div>
                    @endif

                    <div class="row mt-3 pt-3" style="border-top: 2.5px dashed #A69E93;">
                        <div class="col-6 fw-bold fs-5" style="color: #4A3F35;">Total Akhir</div>
                        <div class="col-6 text-end fw-bold fs-5 text-primary">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                    </div>

                </div>
            </div>

            @if($returnClaim)
            <div class="card shadow-sm mt-4 bg-white" style="border-radius: 16px; border: 1.5px solid #C4B9B1;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: #4A3F35;">
                        <i class="bx bx-undo text-warning me-2"></i>Status Retur
                    </h5>

                    <div class="bg-light rounded p-3 mb-3" style="border-left: 4px solid {{ $returnClaim->status === 'APPROVED' ? '#198754' : ($returnClaim->status === 'REJECTED' ? '#DC3545' : '#ffc107') }};">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            @php
                                $returBadge = match($returnClaim->status) {
                                    'PENDING' => ['bg-warning text-dark', 'Sedang Diproses'],
                                    'APPROVED' => ['bg-success text-white', 'Disetujui'],
                                    'REJECTED' => ['bg-danger text-white', 'Ditolak'],
                                    default => ['bg-secondary text-white', $returnClaim->status],
                                };
                            @endphp
                            <span class="badge {{ $returBadge[0] }} px-3 py-2">{{ $returBadge[1] }}</span>
                            <small class="text-muted">{{ $returnClaim->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <p class="mb-2 fw-semibold" style="font-size: 14px;">Alasan: <span class="fw-normal">{{ $returnClaim->reason }}</span></p>
                        @if($returnClaim->proof_image)
                            <div>
                                <small class="text-muted fw-bold d-block mb-1">Bukti Foto:</small>
                                <img src="{{ asset('storage/' . $returnClaim->proof_image) }}" alt="Bukti retur" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6;">
                            </div>
                        @endif
                        @if($returnClaim->status === 'APPROVED' && $returnClaim->approved_at)
                            <div class="mt-2 text-success fw-semibold" style="font-size: 13px;">
                                <i class="bx bx-check-circle me-1"></i> Disetujui pada {{ \Carbon\Carbon::parse($returnClaim->approved_at)->format('d M Y H:i') }}
                            </div>
                        @endif
                        @if($returnClaim->status === 'REJECTED' && $returnClaim->rejected_at)
                            <div class="mt-2 text-danger fw-semibold" style="font-size: 13px;">
                                <i class="bx bx-x-circle me-1"></i> Ditolak pada {{ \Carbon\Carbon::parse($returnClaim->rejected_at)->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-Ld46vSvb5dDsQkxP"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        var payButton = document.getElementById('pay-button');
        
        if (payButton) {
            payButton.onclick = function() {
                snap.pay('{{ $payment->token ?? "" }}', {
                    onSuccess: function(result){
                        showLuxuryToast('Berhasil', 'Pembayaran Berhasil! Tunggu konfirmasi dari kami.', 'success');
                        window.location.reload();
                    },
                    onPending: function(result){
                        showLuxuryToast('Perhatian', 'Menunggu pembayaran Anda!', 'warning');
                        window.location.reload();
                    },
                    onError: function(result){
                        showLuxuryToast('Gagal', 'Pembayaran gagal. Silakan coba lagi.', 'error');
                        window.location.reload();
                    },
                    onClose: function(){
                        // Dikosongkan agar tidak ada pop-up mengganggu saat pelanggan menutup halaman bayar
                    }
                });
            };
        }
    });
</script>
@endsection