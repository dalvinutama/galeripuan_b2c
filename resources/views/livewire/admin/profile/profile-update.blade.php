<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle text-uppercase text-muted fw-bold">
                        Pengaturan
                    </div>
                    <h2 class="page-title fw-bold">
                        Profil Admin
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-lg-8">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="bx bx-check-circle me-2" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <h4 class="alert-title">Berhasil!</h4>
                                    <div class="text-secondary">{{ session('success') }}</div>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif

                    <form wire:submit="updateProfile" class="card shadow-sm border-0">
                        <div class="card-header bg-white pb-3 pt-4">
                            <h3 class="card-title fw-bold">Data Pribadi</h3>
                        </div>
                        <div class="card-body bg-light">
                            <div class="mb-3">
                                <label class="form-label required fw-medium">Nama Tampilan (Admin)</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Masukkan nama Anda">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label required fw-medium">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" placeholder="admin@gallerypuan.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="card-header bg-white pb-3 pt-4 border-top">
                            <h3 class="card-title fw-bold">Keamanan (Ganti Password)</h3>
                            <p class="card-subtitle mt-1">Kosongkan bagian ini jika Anda tidak ingin mengganti kata sandi.</p>
                        </div>
                        <div class="card-body bg-light">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Kata Sandi Saat Ini</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" wire:model="current_password" placeholder="Masukkan kata sandi saat ini">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Kata Sandi Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" wire:model="new_password" placeholder="Minimal 8 karakter">
                                    @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Ulangi Kata Sandi Baru</label>
                                    <input type="password" class="form-control" wire:model="new_password_confirmation" placeholder="Ulangi kata sandi baru">
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white text-end py-3">
                            <button type="submit" class="btn btn-primary shadow-sm px-4">
                                <i class="bx bx-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <div class="avatar avatar-xl bg-primary text-white mb-3" style="font-size: 3rem; font-weight: bold; width: 100px; height: 100px;">
                                {{ substr(auth('admin')->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <h3 class="mb-1 fw-bold">{{ auth('admin')->user()->name ?? 'Admin' }}</h3>
                            <div class="text-muted mb-4">{{ auth('admin')->user()->email ?? 'admin@email.com' }}</div>
                            <span class="badge bg-success-lt px-3 py-2">Administrator Utama</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
