<div wire:ignore.self class="modal modal-blur fade" id="modal-product-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button wire:click="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="mb-3">
                    <label class="form-label required">Kode SKU</label>
                    <input wire:model="sku" type="text" class="form-control @error('sku') is-invalid @enderror" placeholder="Contoh: HIJAB-001">
                    @error('sku')
                    <span class="text-danger small">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Nama Produk</label>
                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Hijab Bella Square">
                    @error('name')
                    <span class="text-danger small">{{$message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Tipe Produk</label>
                    <select wire:model="type" class="form-select">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="SIMPLE">Produk Standar (Satu Jenis)</option>
                        <option value="CONFIGURABLE">Produk dengan Varian (Warna/Ukuran)</option>
                    </select>
                    @error('type')
                    <span class="text-danger small">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <a wire:click="close" href="#" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</a>
                <button wire:click="save" type="button" class="btn btn-primary">Simpan & Lanjutkan</button>
            </div>
        </div>
    </div>
</div>