@extends('layouts.app')

@section('content')
<div style="background-color: #FAF7F2; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="w-100" style="max-width: 500px;">
        <div class="card border-0 shadow-lg p-3 p-sm-4" style="border-radius: 24px; background-color: #FFFFFF;">
            <div class="card-body">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="color: #4A3F35; font-family: 'Playfair Display', serif; letter-spacing: 0.5px;">Buat Akun Baru</h3>
                    <p class="text-muted small">Daftar sekarang dan mulailah pengalaman belanja yang menyenangkan</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small" style="color: #4A3F35;">Nama Lengkap</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small" style="color: #4A3F35;">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="password" class="form-label fw-semibold small" style="color: #4A3F35;">Kata Sandi</label>
                            <div class="position-relative">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="padding: 12px 45px 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                                <span id="togglePasswordRegister" class="position-absolute" style="right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #8C7A6B; z-index: 10; transition: color 0.2s ease;" onmouseover="this.style.color='#4A3F35'" onmouseout="this.style.color='#8C7A6B'">
                                    <i class="bx bx-hide fs-5"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label for="password-confirm" class="form-label fw-semibold small" style="color: #4A3F35;">Konfirmasi Sandi</label>
                            <div class="position-relative">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="padding: 12px 45px 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                                <span id="togglePasswordConfirm" class="position-absolute" style="right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #8C7A6B; z-index: 10; transition: color 0.2s ease;" onmouseover="this.style.color='#4A3F35'" onmouseout="this.style.color='#8C7A6B'">
                                    <i class="bx bx-hide fs-5"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn text-white py-2" style="background-color: #8C7A6B; border-radius: 12px; font-weight: 600; font-size: 15px; letter-spacing: 0.5px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(140, 122, 107, 0.25);">
                            Daftar Akun Baru
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Sudah memiliki akun? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #4A3F35;">Masuk di Sini</a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle for Password
        const togglePasswordRegister = document.querySelector('#togglePasswordRegister');
        const passwordRegister = document.querySelector('#password');
        
        if (togglePasswordRegister && passwordRegister) {
            const iconRegister = togglePasswordRegister.querySelector('i');
            togglePasswordRegister.addEventListener('click', function () {
                const type = passwordRegister.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordRegister.setAttribute('type', type);
                
                if (type === 'password') {
                    iconRegister.classList.remove('bx-show');
                    iconRegister.classList.add('bx-hide');
                } else {
                    iconRegister.classList.remove('bx-hide');
                    iconRegister.classList.add('bx-show');
                }
            });
        }

        // Toggle for Confirm Password
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirm = document.querySelector('#password-confirm');
        
        if (togglePasswordConfirm && passwordConfirm) {
            const iconConfirm = togglePasswordConfirm.querySelector('i');
            togglePasswordConfirm.addEventListener('click', function () {
                const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirm.setAttribute('type', type);
                
                if (type === 'password') {
                    iconConfirm.classList.remove('bx-show');
                    iconConfirm.classList.add('bx-hide');
                } else {
                    iconConfirm.classList.remove('bx-hide');
                    iconConfirm.classList.add('bx-show');
                }
            });
        }
    });
</script>
@endsection