<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle text-uppercase text-muted fw-bold">
                        Katalog
                    </div>
                    <h2 class="page-title fw-bold">
                        Daftar Produk
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-product-create">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pb-3 pt-4">
                    <h3 class="card-title fw-bold">Data Produk</h3>
                </div>
                
                <div class="card-body border-bottom py-3 bg-light">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm-auto d-flex align-items-center mb-3 mb-sm-0">
                            <span class="text-muted me-2">Tampilkan</span>
                            <input type="number" wire:model="perPage" wire:change="changePerPage($event.target.value)" class="form-control form-control-sm text-center shadow-sm" value="8" style="width: 65px;">
                            <span class="text-muted ms-2">data</span>
                        </div>
                        <div class="col-12 col-sm-auto ms-auto d-flex align-items-center">
                            <span class="text-muted me-2 d-none d-sm-inline">Cari:</span>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" wire:model.live="search" class="form-control form-control-sm shadow-sm" placeholder="Ketik nama produk..." style="width: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 px-3 pt-3">
                    @if (session('success'))
                    <div class="alert alert-success m-0">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger m-0">{{ session('error') }}</div>
                    @endif
                </div>
                
                <div class="table-responsive">
                    <table class="table table-vcenter table-hover card-table mt-2">
                        <thead class="bg-light">
                            <tr>
                                <th class="w-1 text-center">Foto</th>
                                <th style="width: 15%">SKU</th>
                                <th>Nama Produk</th>
                                <th class="text-end" style="width: 15%">Harga</th>
                                <th class="text-center" style="width: 10%">Status</th>
                                <th class="text-center" style="width: 10%">Stok</th>
                                <th class="text-center" style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="text-center">
                                    <div class="avatar avatar-md border shadow-sm rounded" style="background-image: url({{ shop_product_image($product->image) }}); background-color: #f8f9fa;"></div>
                                </td>
                                <td><span class="text-muted fw-medium">{{ $product->sku }}</span></td>
                                <td class="fw-bold text-dark">{{ $product->name }}</td>
                                <td class="text-end fw-medium">
                                    @if ($product->hasSalePrice && $product->discount_percent > 0)
                                        <div class="text-danger fw-bold">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                        <div class="text-muted text-decoration-line-through" style="font-size: 12px;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        <span class="badge bg-red-lt mt-1">Diskon {{ $product->discount_percent }}%</span>
                                    @else
                                        <div class="fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($product->status == 'ACTIVE')
                                        <span class="badge bg-success text-white px-2 py-1">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold">
                                    @if($product->manage_stock && $product->inventory)
                                        @if($product->inventory->qty <= $product->inventory->low_stock_threshold)
                                            <span class="text-danger" title="Stok Menipis">{{ $product->inventory->qty }}</span>
                                        @else
                                            <span class="text-success">{{ $product->inventory->qty }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted fw-normal" style="font-size: 12px;">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.products.update', [$product->id]) }}">
                                            Edit
                                        </a>
                                        <button wire:click="delete('{{ $product->id }}')" wire:confirm="Yakin ingin menghapus produk ini secara permanen?" class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bx bx-package text-muted mb-2" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <p class="text-muted mb-0">Belum ada produk yang ditambahkan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center bg-white border-top-0">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.product.product-create/>
</div>