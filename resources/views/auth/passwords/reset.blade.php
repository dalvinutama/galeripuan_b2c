@extends('layouts.app')

@section('content')
<div style="background-color: #FAF7F2; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="w-100" style="max-width: 500px;">
        <div class="card border-0 shadow-lg p-3 p-sm-4" style="border-radius: 24px; background-color: #FFFFFF;">
            <div class="card-body">
                
                <div class="text-center mb-4">
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 70px; height: 70px; background-color: #FAF7F2; color: #8C7A6B;">
                        <i class="bx bx-key" style="font-size: 32px;"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #4A3F35; font-family: 'Playfair Display', serif; letter-spacing: 0.5px;">Atur Ulang Sandi</h3>
                    <p class="text-muted small">Silakan buat kata sandi baru untuk akun Gallery Puan Anda.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small" style="color: #4A3F35;">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #f8f9fa; font-size: 14px; color: #6c757d;">
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="password" class="form-label fw-semibold small" style="color: #4A3F35;">Kata Sandi Baru</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label for="password-confirm" class="form-label fw-semibold small" style="color: #4A3F35;">Ulangi Sandi Baru</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #E1DDD7; background-color: #FAF7F2; font-size: 14px;">
                        </div>
                    </div>

                    <div class="d-grid mb-2">
                        <button type="submit" class="btn text-white py-2" style="background-color: #8C7A6B; border-radius: 12px; font-weight: 600; font-size: 15px; letter-spacing: 0.5px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(140, 122, 107, 0.25);">
                            Simpan Kata Sandi Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection