<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Promo & Voucher</h2>
                    <p class="text-muted">Kelola kode diskon untuk memancing pelanggan berbelanja.</p>
                </div>
                <div class="col-auto ms-auto d-flex gap-2">
                    <a href="/admin/marketing/promo-blast" wire:navigate class="btn btn-warning fw-bold text-dark">
                        <i class="bx bx-envelope fs-3 me-2"></i> Blast Promo Email
                    </a>
                    <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalvoucher" wire:click="resetFields">
                        <i class="bx bx-plus fs-3 me-2"></i> Tambah voucher Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show fw-bold">
                    <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom py-3">
                    <div class="d-flex w-100">
                        <div class="ms-auto text-muted">
                            <div class="input-icon">
                                <span class="input-icon-addon"><i class="bx bx-search"></i></span>
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kode voucher...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>Kode voucher</th>
                                <th>Tipe</th>
                                <th>Nilai Diskon</th>
                                <th>Syarat Belanja</th>
                                <th>Khusus Pengguna Baru</th>
                                <th>Syarat Pesanan</th> <!-- TAMBAHAN -->
                                <th>Kedaluwarsa</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vouchers as $voucher)
                            <tr>
                                <td><span class="badge bg-primary-lt fw-bold fs-5">{{ $voucher->code }}</span></td>
                                <td>Nominal (Rp)</td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                </td>
                                <td>Min. Rp {{ number_format($voucher->min_total, 0, ',', '.') }}</td>
                                <td>
                                    @if ($voucher->is_first_order_only)
                                        <span class="badge bg-purple text-white">Ya</span>
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td class="{{ $voucher->expired_at < now() ? 'text-danger fw-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($voucher->expired_at)->format('d M Y') }}
                                </td>
                                <td>
                                    @if ($voucher->is_active && $voucher->expired_at >= now())
                                        <span class="badge bg-success text-white">Aktif</span>
                                    @else
                                        <span class="badge bg-danger text-white">Non-Aktif / Kedaluwarsa</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($voucher->min_order_count > 0)
                                        <span class="badge bg-info text-white">Pesanan Ke-{{ $voucher->min_order_count }}</span>
                                    @else
                                        <span class="text-secondary">Umum</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalvoucher" wire:click="edit('{{ $voucher->id }}')">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="delete('{{ $voucher->id }}')" onclick="confirm('Yakin ingin menghapus voucher ini secara permanen?') || event.stopImmediatePropagation()">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bx bxs-discount fs-1 mb-2"></i><br>
                                    Belum ada data voucher promo.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>

   <!-- MODAL FORM voucher -->
    <div wire:ignore.self class="modal fade" id="modalvoucher" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">{{ $isEditMode ? 'Edit voucher' : 'Tambah voucher Baru' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode voucher *</label>
                            <input type="text" wire:model="code" class="form-control text-uppercase" placeholder="Contoh: PUANPAYDAY" {{ $isEditMode ? 'readonly' : '' }}>
                            @error('code') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Promo *</label>
                            <input type="text" wire:model="description" class="form-control" placeholder="Contoh: Diskon Khusus Pesanan Ke-5">
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe Diskon *</label>
                                <select wire:model="type" class="form-select" disabled>
                                    <option value="fixed">Nominal (Rupiah)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nilai Diskon *</label>
                                <input type="number" wire:model="value" class="form-control" placeholder="Contoh: 50000">
                                @error('value') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Minimal Belanja (Rp) *</label>
                            <input type="number" wire:model="min_total" class="form-control" placeholder="Isi 0 jika tanpa minimal">
                            @error('min_total') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kedaluwarsa *</label>
                            <input type="date" wire:model="expired_at" class="form-control">
                            @error('expired_at') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- SWITCH: Khusus Pelanggan Pertama -->
                        <div class="mb-3 border rounded p-3 bg-light">
                            <label class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" wire:model="is_first_order_only">
                                <span class="form-check-label fw-bold">Khusus Untuk Pengguna Baru</span>
                            </label>
                            <small class="text-muted d-block mt-1">Jika dicentang, voucher ini hanya bisa dipakai oleh pelanggan yang belum pernah belanja sebelumnya.</small>
                        </div>

                        <!-- INPUT: Syarat Pesanan Ke-X (Dimasukkan ke dalam modal-body) -->
                        <div class="mb-3">
                            <label class="form-label">Syarat Pesanan Ke-? (Opsional)</label>
                            <input type="number" wire:model="min_order_count" class="form-control" placeholder="Isi 5 untuk promo checkout ke-5" {{ $is_first_order_only ? 'disabled' : '' }}>
                            <small class="text-muted">Isi 0 jika berlaku untuk semua pesanan.</small>
                            @error('min_order_count') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- SWITCH: Aktif / Non Aktif -->
                        <div class="mb-2">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="is_active">
                                <span class="form-check-label">Aktifkan voucher Ini</span>
                            </label>
                        </div>
                    </div> <!-- Penutup modal-body -->
                    
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script menutup modal otomatis setelah sukses simpan -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                let modalEl = document.getElementById('modalvoucher');
                let modal = bootstrap.Modal.getInstance(modalEl);
                if(modal) modal.hide();
            });
        });
    </script>
</div>
