<style>
    @media (max-width: 576px) {
        .product-name {
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
        }
        .price {
            font-size: 15px !important;
        }
        .add-cart-text {
            font-size: 10px !important;
            padding: 8px 8px !important;
            gap: 4px !important;
        }
        .wishlist-btn {
            padding: 8px 8px !important;
        }
    }
</style>
<div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card card-product card-body p-2 p-md-3" style="border-radius: 0; border: 2px solid #E8E2D9; transition: all 0.4s ease; background-color: #FFFFFF;" onmouseover="this.style.borderColor='#1A110D'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.borderColor='#E8E2D9'; this.style.boxShadow='none';">
        <div class="product-image-box" style="background-color: #F9F6F0; border-radius: 0; overflow: hidden; margin-bottom: 16px; aspect-ratio: 3/4; position: relative;">

            @php
                $isWishlisted = false;
                if(auth()->check()) {
                    $isWishlisted = \Modules\Shop\Entities\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                }
            @endphp

            @if ($product->hasSalePrice && $product->discount_percent > 0)
                <div class="position-absolute shadow-sm" style="top: 10px; right: 10px; background-color: #D32F2F; color: #FFFFFF; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px; z-index: 10; letter-spacing: 0.5px;">
                    Diskon {{ $product->discount_percent }}%
                </div>
            @endif

            <a href="{{ shop_product_link($product) }}" class="d-block w-100 h-100" style="overflow: hidden;">
                <img src="{{ shop_product_image($product->image, 'img-medium') }}" alt="{{ $product->name }}" class="img-fluid w-100 h-100" style="object-fit: cover; transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </a>
        </div>
        
        <div class="text-center px-1">
            <h3 class="product-name" style="font-size: 15px; font-weight: 800; color: #1A110D; margin-bottom: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; letter-spacing: 1px; text-transform: uppercase;">
                {{ $product->name }}
            </h3>
        
            <div class="rating mb-2" style="font-size: 11px;">
                <i class="bx bxs-star" style="color: #C5A059;"></i>
                <i class="bx bxs-star" style="color: #C5A059;"></i>
                <i class="bx bxs-star" style="color: #C5A059;"></i>
                <i class="bx bxs-star" style="color: #C5A059;"></i>
                <i class="bx bxs-star" style="color: #C5A059;"></i>
            </div>
            
            <div class="detail d-flex flex-column mt-1">
                <div class="mb-3">
                    @if ($product->hasSalePrice && $product->discount_percent > 0)
                        <span class="price" style="font-family: 'Playfair Display', serif; font-size: 17px; color: #D32F2F; font-weight: 900; letter-spacing: 0.5px;">Rp {{ $product->sale_price_label }}</span>
                        <span class="text-decoration-line-through ms-1" style="font-size: 12px; color: #888;">Rp {{ $product->price_label }}</span>
                    @else
                        <span class="price" style="font-family: 'Playfair Display', serif; font-size: 17px; color: #1A110D; font-weight: 900; letter-spacing: 0.5px;">Rp {{ $product->price_label }}</span>
                    @endif
                </div>
                
                {{ html()->form('post', route('carts.store'))->class('m-0 w-100 add-to-cart-form')->open() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                    <input type="hidden" name="qty" value="1"/>
                    
                    <div class="d-flex gap-2">
                        @if(strtoupper($product->type) == 'CONFIGURABLE')
                            @php
                                $qvVariants = $product->variants->map(function($v) {
                                    return [
                                        'id' => $v->id,
                                        'color' => $v->attributes['color'] ?? 'Warna',
                                        'stock' => $v->inventory->qty ?? 0
                                    ];
                                });
                            @endphp
                            <button type="button" onclick="openQuickView(event, '{{ addslashes($product->name) }}', this.getAttribute('data-variants'))" data-variants="{{ json_encode($qvVariants) }}" class="btn flex-grow-1 add-cart-text" style="font-size: 12px; color: #3E2723; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s ease; background: transparent; border: 1px solid #3E2723; padding: 10px 15px; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px;" onmouseover="this.style.backgroundColor='#3E2723'; this.style.color='#FFFFFF';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3E2723';">
                                Tambah <i class="bx bx-cart-alt"></i>
                            </button>
                        @else
                            <button type="submit" class="btn flex-grow-1 add-cart-text" style="font-size: 12px; color: #3E2723; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s ease; background: transparent; border: 1px solid #3E2723; padding: 10px 15px; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px;" onmouseover="this.style.backgroundColor='#3E2723'; this.style.color='#FFFFFF';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3E2723';">
                                Tambah <i class="bx bx-cart-alt"></i>
                            </button>
                        @endif
                        <button type="button" class="btn wishlist-btn" data-product="{{ $product->id }}" style="border: 1px solid #E8E2D9; background: #F9F6F0; border-radius: 4px; padding: 10px 12px; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#FFFFFF'; this.style.borderColor='#3E2723';" onmouseout="this.style.backgroundColor='#F9F6F0'; this.style.borderColor='#E8E2D9';">
                            <i class="bx {{ $isWishlisted ? 'bxs-heart text-danger' : 'bx-heart' }}" style="font-size: 16px; color: {{ $isWishlisted ? '' : '#5D4B46' }};"></i>
                        </button>
                    </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>