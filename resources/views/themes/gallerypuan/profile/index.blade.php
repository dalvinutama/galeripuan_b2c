@extends('themes.gallerypuan.layouts.app')

@section('content')

<style>
    :root {
        --gold-primary: #c49a45;
        --gold-hover: #b38a36;
        --light-bg: #fdfcf9;
    }

    body {
        background-color: var(--light-bg);
    }

    /* Ikon Judul Halaman */
    .page-icon-box {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--gold-primary);
        border-radius: 12px;
        color: var(--gold-primary);
        background-color: #fff;
    }

    /* Tombol Utama (Emas) */
    .btn-gold {
        background: var(--gold-primary);
        color: #fff;
        border-radius: 50px;
        padding: 10px 24px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
    }
    .btn-gold:hover {
        background: var(--gold-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(196, 154, 69, 0.2);
    }

    /* Header Card Transparan */
    .custom-header-transparent {
        background: transparent;
        border-bottom: 1px solid #eaeaea;
    }

    /* Input Styling */
    .form-control {
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: var(--gold-primary);
        box-shadow: 0 0 0 0.25rem rgba(196, 154, 69, 0.15);
    }
    
    /* Style khusus untuk input yang didisable */
    .input-disabled-custom {
        background-color: #f8f9fa;
        cursor: not-allowed;
        border-color: #eaeaea;
    }
</style>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center">
            <div class="page-icon-box shadow-sm me-3">
                <i class="bx bx-user fs-3"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-dark" style="font-family: 'Playfair Display', serif;">Akun Saya</h2>
                <p class="text-muted mb-0 small">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            <div class="card shadow-sm border-0 rounded-4" style="overflow: hidden;">
                
                <div class="card-header custom-header-transparent py-3 px-4">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                        <i class="bx bx-id-card text-warning me-2 fs-4"></i> Biodata Diri
                    </h5>
                </div>
                
                <div class="card-body p-4 bg-white">
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold mb-1">Nama Lengkap *</label>
                                <input type="text" class="form-control rounded-3 py-2" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap Anda" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold mb-1">Alamat Email</label>
                                <input type="email" class="form-control rounded-3 py-2 input-disabled-custom text-muted" value="{{ $user->email }}" disabled readonly>
                                <small class="text-muted mt-1 d-block"><i class="bx bx-info-circle me-1"></i>Email tidak dapat diubah.</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold mb-1">Nomor Handphone</label>
                                <div class="input-group shadow-sm-hover">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                                        <i class="bx bx-phone"></i>
                                    </span>
                                    <input type="text" class="form-control rounded-end-3 border-start-0 py-2 ps-0" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                        </div>

                        <hr style="border-style: dashed; opacity: 0.15;" class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-gold shadow-sm px-4 d-flex align-items-center">
                                <i class="bx bx-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection