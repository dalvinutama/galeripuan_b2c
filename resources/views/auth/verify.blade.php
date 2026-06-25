@extends('layouts.app')

@section('content')
<div style="background-color: #FAF7F2; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="w-100" style="max-width: 500px;">
        <div class="card border-0 shadow-lg p-3 p-sm-4 text-center" style="border-radius: 24px; background-color: #FFFFFF;">
            <div class="card-body">
                
                <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 80px; height: 80px; background-color: #FAF7F2; color: #8C7A6B;">
                    <i class="bx bx-envelope" style="font-size: 40px;"></i>
                </div>

                <h3 class="fw-bold mb-2" style="color: #4A3F35; font-family: 'Playfair Display', serif;">Verifikasi Email Anda</h3>
                <p class="text-muted small mb-4">Satu langkah lagi untuk mengaktifkan akun belanja Anda</p>

                @if (session('resent'))
                    <div class="alert alert-success border-0 rounded-3 mb-4 text-start d-flex align-items-center gap-2" role="alert" style="background-color: #d1e7dd; color: #0f5132; font-size: 14px;">
                        <i class="bx bx-check-circle fs-5"></i> Tautan verifikasi baru berhasil dikirim ke email Anda.
                    </div>
                @endif

                <div class="p-3 mb-4 rounded-3 text-start" style="background-color: #FAF7F2; border: 1px dashed #E1DDD7;">
                    <p class="mb-0 text-muted small" style="line-height: 1.6;">
                        Sebelum melanjutkan, silakan periksa kotak masuk (inbox) atau folder spam email Anda untuk mengklik tautan verifikasi yang kami kirimkan.
                    </p>
                </div>

                <p class="text-muted small mb-3">Tidak menerima email verifikasi?</p>
                
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn text-white px-4 py-2" style="background-color: #4A3F35; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all 0.3s ease;">
                        Kirim Ulang Tautan
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection