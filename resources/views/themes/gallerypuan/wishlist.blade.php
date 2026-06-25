@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5" style="min-height: 70vh;">
    <div class="row mb-5 justify-content-center text-center">
        <div class="col-12 col-md-8">
            <h2 class="fw-bold mb-3" style="color: #2C1E16;"><i class="bx bxs-heart text-danger"></i> Daftar Keinginan</h2>
            <p class="text-muted" style="font-size: 15px;">Simpan produk hijab dan busana premium favorit Anda untuk dibeli di kemudian hari. Jangan sampai kehabisan koleksi terbatas kami.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                @forelse ($wishlists as $wishlist)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm position-relative card-product" style="border-radius: 16px; overflow: hidden; transition: all 0.3s ease;">
                            
                            <!-- Delete Button -->
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                <form action="{{ route('wishlist.toggle') }}" method="POST" onsubmit="confirmLuxury(event, this, 'Hapus Produk', 'Hapus produk ini dari daftar keinginan Anda?', 'trash')">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                    <button type="submit" class="btn btn-sm bg-white text-danger shadow border-0 d-flex align-items-center justify-content-center" style="border-radius: 50%; width: 36px; height: 36px; padding: 0;" title="Hapus dari wishlist">
                                        <i class='bx bx-trash fs-5'></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Image Container -->
                            <a href="{{ shop_product_link($wishlist->product) }}" class="d-block text-decoration-none">
                                <div style="height: 280px; background-color: #FAF7F2; overflow: hidden;" class="product-image-box">
                                    @if($wishlist->product && $wishlist->product->image)
                                        <img src="{{ shop_product_image($wishlist->product->image, true) }}" class="card-img-top h-100 w-100" style="object-fit: cover; transition: transform 0.5s ease;" alt="{{ $wishlist->product->name }}">
                                    @else
                                        <img src="{{ asset('themes/gallerypuan/assets/img/product_single_01.jpg') }}" class="card-img-top h-100 w-100" style="object-fit: cover; transition: transform 0.5s ease;" alt="Default Image">
                                    @endif
                                </div>
                            </a>

                            <!-- Content -->
                            <div class="card-body d-flex flex-column p-4 bg-white">
                                <a href="{{ shop_product_link($wishlist->product) }}" class="text-decoration-none">
                                    <h6 class="card-title fw-bold mb-2 product-name-hover" style="color: #2C1E16; line-height: 1.4; transition: color 0.3s;">
                                        {{ $wishlist->product->name }}
                                    </h6>
                                </a>
                                <p class="card-text fw-bold mb-4" style="color: #8C7A6B; font-size: 16px;">
                                    Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}
                                </p>
                                
                                <div class="mt-auto">
                                    <form action="{{ route('carts.store') }}" method="POST" class="add-to-cart-form w-100">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn w-100 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #2C1E16; border-radius: 10px; padding: 10px; transition: background-color 0.3s ease;">
                                            <i class="bx bx-cart-add fs-5"></i> Tambah Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 120px; height: 120px; background-color: #FAF7F2;">
                                <i class="bx bx-heart" style="font-size: 4rem; color: #D1A7A0;"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: #2C1E16;">Belum Ada Produk Impian</h4>
                        <p class="text-muted mb-4 mx-auto" style="max-width: 400px; font-size: 15px;">Daftar keinginan Anda masih kosong. Mari temukan koleksi hijab premium yang cocok untuk gaya elegan Anda.</p>
                        <a href="{{ route('products.index') }}" class="btn text-white px-5 py-3 fw-bold shadow-sm" style="background-color: #B6867F; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
                            Eksplorasi Koleksi Sekarang
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<style>
    /* Efek hover pada kartu produk */
    .card-product:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
    }
    
    /* Efek zoom gambar saat hover */
    .card-product:hover .card-img-top {
        transform: scale(1.08);
    }

    /* Efek hover teks judul produk */
    .product-name-hover:hover {
        color: #B6867F !important;
    }

    /* Efek hover tombol keranjang */
    .card-product button[type="submit"]:hover {
        background-color: #B6867F !important;
    }
</style>
@endsection
