@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bx bx-heart text-warning"></i> Daftar Keinginan</h2>
            <p class="text-muted">Simpan produk hijab favorit Anda untuk dibeli di kemudian hari.</p>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 8px;">
                    <i class='bx bx-check-circle'></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($wishlists as $wishlist)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm position-relative" style="border-radius: 12px; overflow: hidden; transition: transform 0.2s;">
                            
                            <div class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                                <form action="{{ route('wishlist.toggle') }}" method="POST" onsubmit="confirmLuxury(event, this, 'Hapus Produk', 'Hapus produk ini dari daftar keinginan Anda?', 'trash')">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                    <button type="submit" class="btn btn-sm bg-white text-danger shadow-sm border" style="border-radius: 50%; width: 32px; height: 32px; padding: 0;" title="Hapus">
                                        <i class='bx bx-trash fs-5' style="vertical-align: middle;"></i>
                                    </button>
                                </form>
                            </div>

                            <a href="{{ shop_product_link($wishlist->product) }}" class="d-block text-decoration-none">
                                <div style="height: 220px; background-color: #FAF7F2; overflow: hidden;">
                                    @if($wishlist->product && $wishlist->product->image)
                                        <img src="{{ shop_product_image($wishlist->product->image, true) }}" class="card-img-top h-100 w-100" style="object-fit: cover;" alt="{{ $wishlist->product->name }}">
                                    @else
                                        <img src="{{ asset('themes/gallerypuan/assets/img/product_single_01.jpg') }}" class="card-img-top h-100 w-100" style="object-fit: cover;" alt="Default Image">
                                    @endif
                                </div>
                            </a>

                            <div class="card-body d-flex flex-column p-3 bg-white">
                                <a href="{{ shop_product_link($wishlist->product) }}" class="text-decoration-none">
                                    <h6 class="card-title fw-bold text-truncate mb-1" style="color: #4A3F35;">
                                        {{ $wishlist->product->name }}
                                    </h6>
                                </a>
                                <p class="card-text fw-bold text-dark mb-3">
                                    Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}
                                </p>
                                
                                <a href="{{ shop_product_link($wishlist->product) }}" class="btn btn-sm w-100 text-white mt-auto fw-medium" style="background-color: #8C7A6B; border-radius: 6px; padding: 8px;">
                                    Lihat Produk
                                </a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="bx bx-heart text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                        <h5 class="fw-bold" style="color: #4A3F35;">Daftar keinginan Anda masih kosong</h5>
                        <p class="text-muted small">Jelajahi produk hijab premium kami dan simpan yang Anda sukai di sini!</p>
                        <a href="{{ url('/products') }}" class="btn text-white mt-3 px-4" style="background-color: #8C7A6B; border-radius: 8px;">
                            Mulai Cari Hijab
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<style>
    /* Efek hover halus pada kartu produk wishlist */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
</style>
@endsection