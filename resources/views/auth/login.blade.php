@extends('layouts.app')

@section('content')
<div style="background-color: #FAF7F2; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="w-100" style="max-width: 450px;">
        <div class="card border-0 shadow-lg p-3 p-sm-4" style="border-radius: 24px; background-color: #FFFFFF;">
            <div class="card-body">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="color: #4A3F35; font-family: 'Playfair Display', serif; letter-spacing: 0.5px;">Selamat Datang</h3>
                    <p class="text-muted small">Silakan masuk ke akun Anda untuk melanjutkan belanja</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small" style="color: #4A3F35;">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-semibold small mb-0" style="color: #4A3F35;">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small" href="{{ route('password.request') }}" style="color: #B8952E; font-size: 12px; font-weight: 500;">
                                    Lupa Sandi?
                                </a>
                            @endif
                        </div>
                        <div class="position-relative">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="padding: 12px 45px 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                            <span id="togglePassword" class="position-absolute" style="right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #8C7A6B; z-index: 10; transition: color 0.2s ease;" onmouseover="this.style.color='#4A3F35'" onmouseout="this.style.color='#8C7A6B'">
                                <i class="bx bx-hide fs-5"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input mt-0" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="border-color: #8C7A6B; cursor: pointer;">
                            <label class="form-check-label text-muted small" for="remember" style="user-select: none; cursor: pointer;">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn text-white py-2" style="background-color: #4A3F35; border-radius: 12px; font-weight: 600; font-size: 15px; letter-spacing: 0.5px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(74, 63, 53, 0.2);">
                            Masuk Sekarang
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #8C7A6B; hover: color: #4A3F35;">Daftar di Sini</a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = togglePassword.querySelector('i');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function (e) {
                // Ubah tipe input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Ubah ikon mata
                if (type === 'password') {
                    icon.classList.remove('bx-show');
                    icon.classList.add('bx-hide');
                } else {
                    icon.classList.remove('bx-hide');
                    icon.classList.add('bx-show');
                }
            });
        }
    });
</script>
@endsection