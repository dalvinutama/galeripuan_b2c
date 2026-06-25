@extends('layouts.app')

@section('content')
<div style="background-color: #FAF7F2; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="w-100" style="max-width: 450px;">
        <div class="card border-0 shadow-lg p-3 p-sm-4" style="border-radius: 24px; background-color: #FFFFFF;">
            <div class="card-body">
                
                <div class="text-center mb-4">
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 70px; height: 70px; background-color: #FAF7F2; color: #8C7A6B;">
                        <i class="bx bx-lock-open-alt" style="font-size: 32px;"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #4A3F35; font-family: 'Playfair Display', serif; letter-spacing: 0.5px;">Lupa Kata Sandi?</h3>
                    <p class="text-muted small">Jangan khawatir, masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda..</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success border-0 rounded-3 mb-4 text-start d-flex align-items-center gap-2" role="alert" style="background-color: #d1e7dd; color: #0f5132; font-size: 14px;">
                        <i class="bx bx-check-circle fs-5"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold small" style="color: #4A3F35;">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white py-2" style="background-color: #4A3F35; border-radius: 12px; font-weight: 600; font-size: 15px; letter-spacing: 0.5px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(74, 63, 53, 0.2);">
                            Kirim Tautan Reset Kata Sandi
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none small fw-bold" style="color: #8C7A6B;">
                            <i class="bx bx-arrow-back me-1"></i> Kembali ke log masuk
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection