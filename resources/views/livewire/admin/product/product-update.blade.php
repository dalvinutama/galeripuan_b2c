<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Edit Produk
                    </h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/products" wire:navigate class="btn btn-white">
                                Kembali
                            </a>
                        </span>
                        <button wire:click="update" class="btn btn-primary d-none d-sm-inline-block" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-md-8">
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h3 class="card-title fw-bold">Informasi Umum</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-warning">
                                <div class="alert-title">Perhatian!</div>
                                Terdapat kesalahan pada isian Anda.
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required fw-medium">Kode SKU</label>
                                    <input wire:model="sku" type="text" class="form-control @error('sku') is-invalid @enderror" />
                                    <small class="form-hint mt-1">Kode unik untuk produk ini.</small>
                                    @error('sku') <span class="text-danger small">{{$message}}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required fw-medium">Berat (Gram)</label>
                                    <input type="number" wire:model="weight" class="form-control @error('weight') is-invalid @enderror" placeholder="Contoh: 250">
                                    @error('weight') <span class="text-danger small">{{$message}}</span> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required fw-medium">Nama Produk</label>
                                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" />
                                <small class="form-hint mt-1 text-primary">Tautan: /product/{{ $product->slug }}</small>
                                @error('name') <span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Deskripsi Singkat</label>
                                <div wire:ignore>
                                    <textarea wire:model="excerpt" class="summernote form-control" rows="3"></textarea>
                                </div>
                                @error('excerpt') <span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label required fw-medium">Kategori Produk</label>
                                <div class="border rounded p-3 @error('category_ids') border-danger @enderror" style="max-height: 180px; overflow-y: auto; background-color: #fcfcfc;">
                                    <div class="row">
                                        @foreach($categories as $category)
                                        <div class="col-6">
                                            <label class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" wire:model="category_ids" value="{{ $category->id }}">
                                                <span class="form-check-label">{{ $category->name }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('category_ids') <span class="text-danger small mt-1 d-block">{{$message}}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Detail Produk (Lengkap)</label>
                                <div wire:ignore>
                                    <textarea wire:model="body" class="summernote form-control" rows="5"></textarea>
                                </div>
                                @error('body') <span class="text-danger small">{{$message}}</span> @enderror
                            </div>

                            @if($product->type == 'CONFIGURABLE')
                            <div class="mb-4 pt-4 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="m-0 fw-bold">Varian Produk (Warna & Stok)</h4>
                                    <button type="button" class="btn btn-sm btn-primary" wire:click="addVariant">
                                        + Tambah Varian
                                    </button>
                                </div>
                                
                                @if(count($variants) > 0)
                                <div class="table-responsive border rounded">
                                    <table class="table table-vcenter table-nowrap mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Warna (Atribut)</th>
                                                <th>SKU</th>
                                                <th>Harga (Rp)</th>
                                                <th>Stok</th>
                                                <th class="w-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($variants as $index => $variant)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" wire:model="variants.{{ $index }}.color" placeholder="Misal: Merah">
                                                    @error('variants.'.$index.'.color') <span class="text-danger small">{{ $message }}</span> @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" wire:model="variants.{{ $index }}.sku">
                                                    @error('variants.'.$index.'.sku') <span class="text-danger small">{{ $message }}</span> @enderror
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm" wire:model="variants.{{ $index }}.price">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm" wire:model="variants.{{ $index }}.qty">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger btn-icon" wire:click="removeVariant({{ $index }})" title="Hapus Varian">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                           <line x1="4" y1="7" x2="20" y2="7"></line>
                                                           <line x1="10" y1="11" x2="10" y2="17"></line>
                                                           <line x1="14" y1="11" x2="14" y2="17"></line>
                                                           <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                           <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-info mb-0">Belum ada varian warna ditambahkan. Klik tombol "+ Tambah Varian" untuk mulai menambahkan.</div>
                                @endif
                            </div>
                            @endif

                            <div class="mb-4 pt-4 border-top">
                                <label class="form-label fw-bold">Unggah Foto Baru</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" wire:model.live="image" />
                                @error('image') <span class="text-danger small mt-1 d-block">{{$message}}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Galeri Foto Produk</label>
                                <small class="form-hint mb-3 text-muted">Klik pada gambar untuk menjadikannya foto sampul utama.</small>
                                <div class="row g-3">
                                    @foreach ($product->images as $productImage)
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <div class="position-relative">
                                            <label class="form-imagecheck mb-0 w-100">
                                                <input wire:click="setFeaturedImage('{{ $productImage->id }}')" name="form-imagecheck-radio" type="radio" value="{{ $productImage->id }}" class="form-imagecheck-input" {{ $product->featured_image == $productImage->id ? 'checked' : '' }} />
                                                <span class="form-imagecheck-figure rounded shadow-sm border p-1 bg-white" style="height: 140px; display: block; cursor: pointer; transition: 0.2s;">
                                                    <img src="{{ shop_product_image($productImage) }}" alt="image" style="object-fit: cover; height: 100%; width: 100%; border-radius: 4px;">
                                                    
                                                    @if($product->featured_image == $productImage->id)
                                                    <div class="position-absolute bottom-0 start-0 w-100 bg-primary text-white text-center py-1 rounded-bottom" style="font-size: 11px; font-weight: bold; opacity: 0.95;">
                                                        SAMPUL
                                                    </div>
                                                    @endif
                                                </span>
                                            </label>
                                            
                                            <button type="button" 
                                                    wire:click="deleteImage('{{ $productImage->id }}')" 
                                                    onclick="confirm('Yakin ingin menghapus foto ini?') || event.stopImmediatePropagation()" 
                                                    class="btn btn-danger btn-sm position-absolute rounded-circle shadow p-0 d-flex align-items-center justify-content-center" 
                                                    style="width: 26px; height: 26px; right: -8px; top: -8px; z-index: 10;" 
                                                    title="Hapus Foto">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <line x1="18" y1="6" x2="6" y2="18" />
                                                    <line x1="6" y1="6" x2="18" y2="18" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h3 class="card-title fw-bold">Status Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-1">
                                <label class="form-label required fw-medium">Visibilitas</label>
                                <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="ACTIVE">Aktif (Tampil di Toko)</option>
                                    <option value="INACTIVE">Nonaktif (Disembunyikan)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h3 class="card-title fw-bold">Pengaturan Harga</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required fw-medium">Harga Normal (Rp)</label>
                                <input wire:model="price" type="number" class="form-control @error('price') is-invalid @enderror" placeholder="Contoh: 150000" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label fw-medium">Harga Diskon (Rp)</label>
                                <input wire:model="sale_price" type="number" class="form-control @error('sale_price') is-invalid @enderror" placeholder="Contoh: 120000" />
                                <small class="form-hint mt-1 text-muted">Opsional. Kosongkan jika tidak ada diskon.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h3 class="card-title fw-bold">Kelola Stok</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-check form-switch cursor-pointer">
                                    <input wire:model="manage_stock" wire:change="changeManageStock" class="form-check-input" type="checkbox" />
                                    <span class="form-check-label fw-bold">Aktifkan Manajemen Stok?</span>
                                </label>
                            </div>
                            
                            @if ($manage_stock)
                            <div class="mb-3 pt-2">
                                <label class="form-label required fw-medium">Jumlah Stok Saat Ini</label>
                                <input wire:model="qty" type="number" class="form-control @error('qty') is-invalid @enderror" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label fw-medium">Batas Minimum Peringatan</label>
                                <input wire:model="low_stock_threshold" type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror" />
                                <small class="form-hint mt-1 text-muted">Sistem akan memberi tahu jika stok di bawah angka ini.</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>