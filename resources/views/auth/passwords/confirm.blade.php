@extends('layouts.app')

@section('content')
<div style="background-color: #FAF7F2; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="w-100" style="max-width: 450px;">
        <div class="card border-0 shadow-lg p-3 p-sm-4" style="border-radius: 24px; background-color: #FFFFFF;">
            <div class="card-body">
                
                <div class="text-center mb-4">
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 70px; height: 70px; background-color: #FAF7F2; color: #8C7A6B;">
                        <i class="bx bx-shield-quarter" style="font-size: 32px;"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #4A3F35; font-family: 'Playfair Display', serif; letter-spacing: 0.5px;">Konfirmasi Keamanan</h3>
                    <p class="text-muted small">Demi keamanan akun Anda, harap konfirmasi kata sandi sebelum melanjutkan.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold small" style="color: #4A3F35;">Kata Sandi Anda</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white py-2" style="background-color: #4A3F35; border-radius: 12px; font-weight: 600; font-size: 15px; letter-spacing: 0.5px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(74, 63, 53, 0.2);">
                            Konfirmasi Kata Sandi
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold" style="color: #8C7A6B;">
                                Lupa Kata Sandi?
                            </a>
                        </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
</div>
@endsection