@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bx bx-lock-alt text-warning"></i> Keamanan Akun</h2>
            <p class="text-muted">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">Ubah Kata Sandi</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                <small class="text-muted">Minimal 8 karakter.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning px-4 fw-bold">Perbarui Kata Sandi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection