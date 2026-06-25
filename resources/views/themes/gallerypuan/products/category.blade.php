@extends('themes.gallerypuan.layouts.app')

@section('content')
<section class="breadcrumb-section pb-4 pb-md-4 pt-4 pt-md-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
    </div>
</section>
<style>
    @media (max-width: 768px) {
        .section-header h2 {
            font-size: 24px !important;
        }
        .custom-select-elegant {
            width: 100% !important;
            margin-top: 10px;
        }
        .breadcrumb-section {
            padding: 20px 0 !important;
        }
        aside {
            margin-bottom: 20px !important;
        }
    }
</style>
<section class="main-content">
    <div class="container">
        <div class="row">
            <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
                @include('themes.gallerypuan.products.sidebar', ['categories' => $categories])
            </aside>
            <section class="col-lg-9 col-md-12 products">
                <div class="section-header d-flex justify-content-between align-items-center pb-2 mb-4" style="border-bottom: 4px solid #1A110D !important;">
                    <h2 class="mb-0 font-serif text-uppercase" style="color: #1A110D; font-size: 32px; font-weight: 900; letter-spacing: 2px;">{{ $category->name }}</h2>
                </div>
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="text-muted" style="font-size: 14px; letter-spacing: 0.5px;">
                            Menampilkan <span style="font-weight: 600; color: #C5A059;">{{ $products->count() }}</span> produk
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end">
                        <form method="GET" action="{{ url()->current() }}" class="d-inline-block w-100 w-md-auto">
                            @if(request('price'))
                                <input type="hidden" name="price" value="{{ request('price') }}">
                            @endif
                            <div class="d-flex justify-content-md-end w-100">
                                <select name="sort" class="custom-select-elegant form-select w-100" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    <option value="">-- sortir produk --</option>
                                    <option value="?sort=price&order=asc" {{ request('sort') == 'price' && request('order') == 'asc' ? 'selected' : '' }}>Harga: Rendah hingga Tinggi</option>
                                    <option value="?sort=price&order=desc" {{ request('sort') == 'price' && request('order') == 'desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                                    <option value="?sort=publish_date&order=desc" {{ request('sort') == 'publish_date' && request('order') == 'desc' ? 'selected' : '' }}>Barang Terbaru</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    @forelse ($products as $product)
                        @include('themes.gallerypuan.products.product_box', ['product' => $product])
                    @empty
                        <p>produk kosong</p>
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