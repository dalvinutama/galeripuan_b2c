<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Kirim Promo / Voucher</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="sendPromo">
                        <div class="mb-3">
                            <label class="form-label">Subjek Email</label>
                            <input type="text" class="form-control" wire:model="subject" placeholder="Contoh: Diskon Spesial Hari Ini!">
                            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Target Penerima</label>
                            <select class="form-select" wire:model="target_audience">
                                <option value="all">Semua Pelanggan</option>
                                <option value="inactive_1_month">Pelanggan Pasif (> 1 Bulan)</option>
                            </select>
                            @error('target_audience') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pesan Promo</label>
                            <textarea class="form-control" wire:model="message" rows="5" placeholder="Tuliskan pesan menarik Anda di sini..."></textarea>
                            @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Voucher (Opsional)</label>
                            <select class="form-select" wire:model="voucher_code">
                                <option value="">-- Tidak Menggunakan Voucher --</option>
                                @foreach($vouchers as $voucher)
                                    <option value="{{ $voucher->code }}">{{ $voucher->code }} (Diskon: {{ $voucher->type == 'percent' ? $voucher->value . '%' : 'Rp ' . number_format($voucher->value, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                            @error('voucher_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-send"></i> Kirim Promo Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
