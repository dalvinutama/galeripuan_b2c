<div wire:ignore.self class="modal modal-blur fade" id="modal-order-update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Pesanan : {{ $action_button_label }}</h5>
                <button wire:click="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                <div class="alert alert-warning">
                    <div class="alert-title">Perhatian!</div>
                    Terdapat kesalahan pada isian Anda:
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Terkini:</label>
                    @php
                        $statusIndo = [
                            'CREATED' => 'Pesanan Baru',
                            'PENDING' => 'Menunggu Pembayaran',
                            'PAID' => 'Sudah Dibayar',
                            'PROCESSING' => 'Sedang Diproses',
                            'DELIVERED' => 'Sedang Dikirim',
                            'RECEIVED' => 'Selesai / Diterima',
                            'CANCELLED' => 'Dibatalkan'
                        ];
                        $teksStatusTerkini = $statusIndo[strtoupper($order_status)] ?? $order_status;
                    @endphp
                    <input type="text" class="form-control bg-light fw-bold" value="{{ $teksStatusTerkini }}" disabled />
                </div>

                @if ($nextActionType == 'DELIVER')
                <div class="mb-4">
                    <label class="form-label fw-bold required">Resi Pengiriman</label>
                    <input wire:model="shipping_number" type="text" class="form-control" {{ (!empty($shipping_number) ? 'disabled': '') }} placeholder="Masukkan nomor resi..." autocomplete="off">
                    @error('shipping_number')
                    <span class="text-danger small">{{$message}}</span>
                    @enderror
                </div>
                @endif
                
            </div>
            <div class="modal-footer">
                <button wire:click="close" type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Tutup</button>
                <button wire:click="update" type="button" class="btn btn-primary">{{ $action_button_label }}</button>
            </div>
        </div>
    </div>
</div>