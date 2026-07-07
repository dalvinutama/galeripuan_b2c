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
            <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
                @include('themes.gallerypuan.products.sidebar', ['categories' => $categories])
            </aside>
            <section class="col-lg-9 col-md-12 products">
                <div class="section-header d-flex justify-content-between align-items-center pb-2 mb-4" style="border-bottom: 4px solid #1A110D !important;">
                    <h2 class="mb-0 font-serif text-uppercase" style="color: #1A110D; font-size: 32px; font-weight: 900; letter-spacing: 2px;">Koleksi Kami</h2>
                </div>
                <div class="row mb-4 align-items-center products-header-row">
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
                                {!! html()->select('sorting', $sortingOptions, $sortingQuery)->class(['custom-select-elegant', 'w-100'])->attribute('onchange', 'this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);') !!}   
                            </div>
                        </form>
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