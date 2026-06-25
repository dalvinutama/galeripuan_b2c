<x-mail::message>
# Halo! 👋

Kabar gembira untuk Anda! Produk impian yang ada di Wishlist Anda sedang turun harga. 

**{{ $product->name }}**
Harga Sebelumnya: ~~Rp {{ number_format($old_price, 0, ',', '.') }}~~
**Harga Sekarang: Rp {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}**

Jangan sampai kehabisan! Stok terbatas dan promo ini bisa berakhir kapan saja.

<x-mail::button :url="shop_product_link($product)">
Checkout Sekarang
</x-mail::button>

Terima kasih telah berbelanja di **Gallery Puan**.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
