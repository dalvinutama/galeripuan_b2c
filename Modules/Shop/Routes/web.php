<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\ProductController;
use Modules\Shop\Http\Controllers\CartController;
use Modules\Shop\Http\Controllers\OrderController;
use Modules\Shop\Http\Controllers\ProfileController;


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/Category', function () { return redirect('/#kategori'); });
Route::get('/Category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');

Route::middleware(['auth'])->group(function() {
    Route::get('orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('orders/shipping-fee', [OrderController::class, 'shippingFee'])->name('orders.shipping_fee');
    Route::post('orders/choose-package', [OrderController::class, 'choosePackage'])->name('orders.choose_package');

    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::get('/carts/{id}/remove', [CartController::class, 'destroy'])->name('carts.destroy');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::put('/carts', [CartController::class, 'update'])->name('carts.update');
    Route::post('orders/checkout/address', [\Modules\Shop\Http\Controllers\OrderController::class, 'storeAddress'])->name('orders.checkout.address.store');
    Route::put('orders/checkout/address/{id}', [\Modules\Shop\Http\Controllers\OrderController::class, 'updateAddress'])->name('orders.checkout.address.update');
    Route::delete('orders/checkout/address/{id}', [\Modules\Shop\Http\Controllers\OrderController::class, 'destroyAddress'])->name('orders.checkout.address.destroy');

    // Route API RajaOngkir untuk Provinsi & Kota
    Route::get('orders/checkout/provinces', [\Modules\Shop\Http\Controllers\OrderController::class, 'getProvinces'])->name('orders.checkout.provinces');
    Route::get('orders/checkout/cities', [\Modules\Shop\Http\Controllers\OrderController::class, 'getCities'])->name('orders.checkout.cities');


    // Rute untuk memproses/menyimpan pesanan dan menembak token Midtrans
    Route::post('orders/checkout', [OrderController::class, 'store'])->name('orders.store');
    
    // Rute untuk menampilkan halaman detail pesanan dan tombol bayar
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/orders', [\Modules\Shop\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update'); // Rute baru untuk Update Profil
    Route::get('/profil/alamat', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/orders/{id}/cancel', [Modules\Shop\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');

    Route::post('carts/apply-voucher', [\Modules\Shop\Http\Controllers\CartController::class, 'applyvoucher'])->name('carts.apply_voucher');
    Route::post('/carts/remove-voucher', [\Modules\Shop\Http\Controllers\CartController::class, 'removevoucher'])->name('carts.remove_voucher');

    Route::get('/profil/password', [\Modules\Shop\Http\Controllers\ProfileController::class, 'password'])->name('profile.password');
    Route::put('/profil/password', [\Modules\Shop\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profil/pesanan', [\Modules\Shop\Http\Controllers\ProfileController::class, 'orders'])->name('profile.orders');

    Route::get('/profil/wishlist', [\Modules\Shop\Http\Controllers\ProfileController::class, 'wishlist'])->name('profile.wishlist');
    Route::get('/wishlist', [\Modules\Shop\Http\Controllers\ProfileController::class, 'wishlistStandalone'])->name('wishlist.standalone');
    Route::post('/wishlist/toggle', [\Modules\Shop\Http\Controllers\ProfileController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::get('/profil/ulasan', [\Modules\Shop\Http\Controllers\ProfileController::class, 'reviews'])->name('profile.reviews');
    Route::post('/profil/ulasan/simpan', [\Modules\Shop\Http\Controllers\ProfileController::class, 'storeReview'])->name('profile.reviews.store');
    Route::get('/profil/voucher', [\Modules\Shop\Http\Controllers\ProfileController::class, 'vouchers'])->name('profile.vouchers');
    Route::post('/orders/{id}/complete', [Modules\Shop\Http\Controllers\OrderController::class, 'complete'])->name('orders.complete');

    Route::get('/returns/{orderId}/create', [Modules\Shop\Http\Controllers\ReturnController::class, 'create'])->name('returns.create');
    Route::post('/returns/{orderId}', [Modules\Shop\Http\Controllers\ReturnController::class, 'store'])->name('returns.store');

});

Route::get('/{categorySlug}/{productSlug}', [ProductController::class, 'show'])->name('products.show');
