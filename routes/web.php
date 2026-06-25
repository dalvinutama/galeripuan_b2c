<?php

use App\Livewire\Admin\Category\CategoryIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Product\ProductIndex;
use App\Livewire\Admin\Product\ProductUpdate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\Order\OrderIndex;
use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Admin\Order\OrderShow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.page');
Route::get('/tentang-kami', function () {
    return view('themes.gallerypuan.about');
})->name('about');

// ==========================================
// 🛡️ AREA KHUSUS ADMIN (MULTI-AUTH)
// ==========================================

// 1. Halaman Login Admin (DI LUAR MIDDLEWARE agar bisa diakses publik)
Route::get('/admin', AdminLogin::class)->name('admin.login');

// 2. Area Dalam Admin (DI DALAM MIDDLEWARE 'auth:admin')
Route::middleware(['auth:admin', 'track.admin'])->prefix('admin')->name('admin.')->group(function() {
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/products', ProductIndex::class)->name('products.index');
    Route::get('/products/{id}/edit', ProductUpdate::class)->name('products.update');
    
    Route::get('/chat', \App\Livewire\Admin\Chat\Index::class)->name('chat');
    Route::get('/chat/settings', \App\Livewire\Admin\Chat\ChatSetting::class)->name('chat.settings');
    
    Route::get('/orders', OrderIndex::class)->name('orders.index');
    Route::get('/orders/{id}', OrderShow::class)->name('orders.show');
    Route::get('/customers', \App\Livewire\Admin\Customer\CustomerIndex::class)->name('customers.index');
    Route::get('/customers/{id}', \App\Livewire\Admin\Customer\CustomerShow::class)->name('customers.show');
    Route::get('/reports', \App\Livewire\Admin\Report\ReportIndex::class)->name('reports');
    Route::get('/vouchers', \App\Livewire\Admin\Voucher\VoucherIndex::class)->name('vouchers.index');
    Route::get('/marketing/promo-blast', \App\Livewire\Admin\Marketing\PromoBlast::class)->name('marketing.promo_blast');
    Route::get('/settings', \App\Livewire\Admin\Setting\SettingIndex::class)->name('settings');
    Route::get('/profile', \App\Livewire\Admin\Profile\ProfileUpdate::class)->name('profile');
    Route::get('/returns', \App\Livewire\Admin\ReturnRequest\ReturnRequestIndex::class)->name('returns.index');
    Route::get('/notifications', \App\Livewire\Admin\NotificationIndex::class)->name('notifications.index');

    // Rute untuk Lonceng Notifikasi Admin
    Route::post('/notifications/mark-as-read', function () {
        auth()->guard('admin')->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('notifications.markAsRead');

    // Rute Logout Khusus Admin
    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/admin');
    })->name('logout');
    
}); // <-- Ini adalah penutup grup admin yang benar

// ==========================================
// AREA PELANGGAN BIASA
// ==========================================
Route::get('/keluar-akun', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout.gampang');