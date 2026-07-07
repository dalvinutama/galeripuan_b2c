@extends('themes.gallerypuan.layouts.app')

@section('content')
<style>
    body { background-color: #FFFDFB; color: #3E2723; font-family: 'Poppins', sans-serif; }
    h1, h2, h3, h4, .font-serif { font-family: 'Playfair Display', serif; }
    
    .breadcrumb-section {
        background-color: #F9F6F0;
        padding: 40px 0;
        border-bottom: 1px solid #E8E2D9;
    }
    .breadcrumb { margin-bottom: 0; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; }
    .breadcrumb-item a { color: #5D4B46; text-decoration: none; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #2C1E16; }
    .breadcrumb-item.active { color: #2C1E16; font-weight: 500; }
    
    .section-header {
        background-color: transparent !important;
        border: none !important;
        margin-bottom: 30px !important;
        padding: 0 !important;
    }
    .section-header h2 {
        font-size: 32px;
        color: #2C1E16;
        letter-spacing: 1px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .custom-select-elegant {
        appearance: none;
        background-color: #FFFFFF;
        border: 1px solid #E8E2D9;
        padding: 10px 40px 10px 20px;
        font-size: 13px;
        color: #3E2723;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%233E2723%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 15px top 50%;
        background-size: 10px auto;
        box-shadow: 0 4px 10px rgba(62, 39, 35, 0.05);
        transition: all 0.3s;
    }
    .custom-select-elegant:focus {
        outline: none;
        border-color: #C5A059;
        box-shadow: 0 4px 15px rgba(197, 160, 89, 0.1);
    }
    
    @media (max-width: 768px) {
        .section-header h2 {
            font-size: 24px !important;
        }
        .custom-select-elegant {
            width: 100% !important;
            margin-top: 10px;
        }
        .breadcrumb-section {
            padding: 20px 0;
        }
        aside {
            margin-bottom: 20px !important;
        }
        .products-header-row {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .products-header-row .text-muted {
            margin-bottom: 15px;
        }
    }
</style>

<section class="breadcrumb-section">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Koleksi Produk</li>
            </ol>
        </nav>
    </div>
</section>
<section class="main-content">
    <div class="container">
        <div class="row">
            <!-- Mobile Header (Hidden on Desktop) -->
            <div class="d-md-none mb-4">
                <h2 class="mb-3 font-serif text-uppercase" style="color: #1A110D; font-size: 26px; font-weight: 900; letter-spacing: 1px;">Koleksi Produk</h2>
                
                <div class="d-flex justify-content-between align-items-center">
                    
                    <!-- Kategori Dropdown -->
                    <div class="dropdown">
                        <button class="btn dropdown-toggle d-flex align-items-center shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: 600; color: #3E2723; font-size: 15px; background: transparent; border: none; padding: 0;">
                            {{ isset($category) ? $category->name : 'Semua Kategori' }}
                        </button>
                        <ul class="dropdown-menu shadow-sm" style="border: 1px solid #E8E2D9; border-radius: 8px;">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}" onclick="window.location.href=this.href; return false;">Semua Kategori</a></li>
                            @if(isset($categories) && $categories->count() > 0)
                                @foreach($categories as $cat)
                                    <li><a class="dropdown-item" href="{{ shop_category_link($cat) }}" onclick="window.location.href=this.href; return false;">{{ $cat->name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <!-- Sort Icon (Mobile) -->
                        <div class="dropdown">
                            <button class="btn btn-sm d-flex align-items-center justify-content-center shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #F9F6F0; border: 1px solid #E8E2D9; color: #3E2723; padding: 6px 10px; border-radius: 6px;" title="Urutkan Produk">
                                <i class='bx bx-sort' style="font-size: 18px;"></i>
                            </button>
                            <ul class="dropdown-menu shadow-sm dropdown-menu-end" style="border: 1px solid #E8E2D9; border-radius: 8px;">
                                <li><a class="dropdown-item" href="?sort=price&order=asc" style="font-size: 14px;">Harga: Rendah ke Tinggi</a></li>
                                <li><a class="dropdown-item" href="?sort=price&order=desc" style="font-size: 14px;">Harga: Tinggi ke Rendah</a></li>
                                <li><a class="dropdown-item" href="?sort=publish_date&order=desc" style="font-size: 14px;">Barang Terbaru</a></li>
                            </ul>
                        </div>
                        
                        <!-- Filter Button -->
                        <button class="btn btn-sm d-flex align-items-center gap-1" style="background-color: #F9F6F0; border: 1px solid #E8E2D9; color: #3E2723; font-weight: 600; padding: 6px 12px; border-radius: 6px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                            <i class='bx bx-filter-alt'></i> Filter
                        </button>
                    </div>
                </div>
            </div>

            <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
                <!-- Wrapper Offcanvas (Aktif di Mobile, Normal di Desktop) -->
                <div class="offcanvas-md offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
                    <div class="offcanvas-header d-md-none border-bottom" style="background-color: #FAF7F2;">
                        <h5 class="offcanvas-title font-serif" id="sidebarOffcanvasLabel" style="font-weight: 700; color: #1A110D; font-size: 20px;">Filter & Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body flex-column p-3 p-md-0" style="background-color: #FFFDFB;">
                        @include('themes.gallerypuan.products.sidebar', ['categories' => $categories])
                    </div>
                </div>
            </aside>
            <section class="col-lg-9 col-md-12 products">
                <div class="section-header d-none d-md-flex justify-content-between align-items-center pb-2 mb-4" style="border-bottom: 4px solid #1A110D !important;">
                    <h2 class="mb-0 font-serif text-uppercase" style="color: #1A110D; font-size: 32px; font-weight: 900; letter-spacing: 2px;">Koleksi Kami</h2>
                </div>
                <div class="row mb-4 align-items-center products-header-row">
                    <div class="col-12 d-none d-md-flex justify-content-end">
                        <div class="dropdown">
                            <button class="btn btn-sm d-flex align-items-center justify-content-center shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #F9F6F0; border: 1px solid #E8E2D9; color: #3E2723; padding: 6px 10px; border-radius: 6px;" title="Urutkan Produk">
                                <i class='bx bx-sort' style="font-size: 18px;"></i>
                            </button>
                            <ul class="dropdown-menu shadow-sm dropdown-menu-end" style="border: 1px solid #E8E2D9; border-radius: 8px;">
                                <li><a class="dropdown-item" href="?sort=price&order=asc" style="font-size: 14px;">Harga: Rendah ke Tinggi</a></li>
                                <li><a class="dropdown-item" href="?sort=price&order=desc" style="font-size: 14px;">Harga: Tinggi ke Rendah</a></li>
                                <li><a class="dropdown-item" href="?sort=publish_date&order=desc" style="font-size: 14px;">Barang Terbaru</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    @forelse ($products as $product)
                        @include('themes.gallerypuan.products.product_box', ['product' => $product])
                    @empty
                        <p>Product empty</p>
                    @endforelse
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        {!! $products->appends(request()->query())->links() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection