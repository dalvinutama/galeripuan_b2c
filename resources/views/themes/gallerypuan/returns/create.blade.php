@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5 mb-5" style="background-color: #FFFFFF;">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            <a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none text-muted mb-3 d-inline-block fw-bold">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Detail Pesanan
            </a>

            <div class="card shadow-sm bg-white" style="border-radius: 16px; border: 1.5px solid #C4B9B1; overflow: hidden;">
                <div class="px-4 py-3 text-white" style="background-color: #2b7a78;">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-undo me-2"></i>Ajukan Retur / Klaim Cacat</h5>
                    <small>Pesanan #{{ $order->code }}</small>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info d-flex align-items-center gap-2 py-2 px-3 mb-4" style="border-radius: 10px;">
                        <i class="bx bx-info-circle fs-5"></i>
                        <small class="fw-medium">Pengajuan retur hanya dapat dilakukan <strong>maksimal 3 hari</strong> setelah pesanan selesai.</small>
                    </div>

                    <form action="{{ route('returns.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="fw-bold mb-2 text-dark">Alasan Retur <span class="text-danger">*</span></label>
                            <textarea name="reason" rows="4" class="form-control @error('reason') is-invalid @enderror" placeholder="Contoh: kain nya bolong min" style="border-radius: 10px; border: 1.5px solid #C4B9B1;" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold mb-2 text-dark">Foto Bukti Cacat <span class="text-danger">*</span></label>
                            <input type="file" name="proof_image" class="form-control @error('proof_image') is-invalid @enderror" accept="image/jpg,image/jpeg,image/png" style="border-radius: 10px; border: 1.5px solid #C4B9B1;" required>
                            <small class="text-muted">Format: JPG/PNG, maksimal 2 MB</small>
                            @error('proof_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary fw-bold rounded-pill px-4" style="border: 1.5px solid #C4B9B1;">Batal</a>
                            <button type="submit" class="btn fw-bold rounded-pill px-4 text-white" style="background-color: #2b7a78; border: 1.5px solid #2b7a78;">
                                <i class="bx bx-send me-1"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
