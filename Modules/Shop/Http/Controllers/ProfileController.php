<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan halaman Biodata Diri
    public function index()
    {
        $this->data['user'] = Auth::user();
        return $this->loadTheme('profile.index', $this->data);
    }

    // Memproses update Biodata Diri
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Karena user Auth tidak bisa langsung pakai method update() jika format datanya berbeda,
        // kita update manual ke tabel users.
        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Biodata diri berhasil diperbarui!');
    }

    // Menampilkan halaman Buku Alamat
    public function addresses()
    {
        $this->data['user'] = auth()->user();
        
        // Mengambil alamat dari tabel shop_addresses milik user yang login
        $this->data['addresses'] = DB::table('shop_addresses')
            ->where('user_id', auth()->id())
            ->orderBy('is_primary', 'desc') // Alamat utama di atas
            ->latest() // Sisanya urut dari yang paling baru ditambah
            ->get();

        return $this->loadTheme('profile.addresses', $this->data);
    }

    // Menampilkan halaman Ubah Password
    public function password()
    {
        $this->data['user'] = Auth::user();
        return $this->loadTheme('profile.password', $this->data);
    }

    // Memproses update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed', // "confirmed" otomatis mencocokkan dengan field "password_confirmation"
        ]);

        // Cek apakah password lama yang dimasukkan sesuai dengan di database
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        // Jika cocok, update dengan password baru (di-hash agar aman)
        DB::table('users')->where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Password Anda berhasil diubah!');
    }

    // Menampilkan riwayat pesanan di dalam halaman profil
    public function orders(Request $request)
    {
        $this->data['user'] = Auth::user();

        // Ambil data pesanan milik user yang login
        $query = \Modules\Shop\Entities\Order::where('user_id', Auth::id())->orderBy('created_at', 'desc');

        // Filter berdasarkan status jika tab diklik
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $this->data['orders'] = $query->get();

        // Arahkan ke file tampilan yang baru
        return $this->loadTheme('profile.orders', $this->data);
    }

    // Menampilkan halaman Wishlist di profil
    public function wishlist()
    {
        $this->data['wishlists'] = \Modules\Shop\Entities\Wishlist::where('user_id', auth()->id())
                                    ->with('product') // Mengambil data produk terkait
                                    ->get();

        return $this->loadTheme('profile.wishlist', $this->data);
    }

    // Menampilkan halaman Standalone Wishlist
    public function wishlistStandalone()
    {
        $this->data['wishlists'] = \Modules\Shop\Entities\Wishlist::where('user_id', auth()->id())
                                    ->with('product') // Mengambil data produk terkait
                                    ->get();

        return $this->loadTheme('wishlist', $this->data);
    }

    
    // Fungsi untuk menambah/menghapus dari wishlist (Toggle)
    public function toggleWishlist(Request $request)
    {
        $productId = $request->product_id;
        $userId = auth()->id();

        $existing = \Modules\Shop\Entities\Wishlist::where('user_id', $userId)
                                                    ->where('product_id', $productId)
                                                    ->first();

        if ($existing) {
            $existing->delete(); // Kalau sudah ada, kita hapus (un-wishlist)
            $status = 'removed';
            $message = 'Produk berhasil dihapus dari daftar keinginan Anda.';
        } else {
            \Modules\Shop\Entities\Wishlist::create(['user_id' => $userId, 'product_id' => $productId]);
            $status = 'added';
            $message = 'Produk berhasil ditambahkan ke daftar keinginan Anda.';
        }

        // Jika request dikirim dari AJAX/JavaScript (misal tombol Love di katalog)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => $status]);
        }

        // Jika request dikirim dari Form HTML biasa (tombol Hapus di Profil Wishlist)
        return back()->with('success', $message);
    }

    // Menampilkan Halaman Ulasan Saya
    public function reviews()
    {
        $userId = auth()->id();

        // 1. Ambil data produk yang SUDAH diulas
        $this->data['reviewed'] = \Modules\Shop\Entities\Review::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        // 2. Cari produk yang BELUM diulas (Pesanan status Selesai/Received)
        $completedOrders = \Modules\Shop\Entities\Order::where('user_id', $userId)
            ->whereIn('status', ['completed', 'received'])
            ->get();

        $unreviewed = [];
        foreach ($completedOrders as $order) {
            // Ambil item produk di dalam pesanan tersebut pakai DB facade biar aman dari error relasi
            $items = \Illuminate\Support\Facades\DB::table('shop_order_items')->where('order_id', $order->id)->get();
            
            foreach ($items as $item) {
                // Cek apakah item ini sudah ada di tabel review?
                $hasReviewed = \Modules\Shop\Entities\Review::where('user_id', $userId)
                    ->where('order_id', $order->id)
                    ->where('product_id', $item->product_id)
                    ->exists();

                // Kalau belum di-review, masukkan ke daftar "Menunggu Ulasan"
                if (!$hasReviewed) {
                    $product = \Modules\Shop\Entities\Product::find($item->product_id);
                    if ($product) {
                        $unreviewed[] = [
                            'order' => $order,
                            'product' => $product
                        ];
                    }
                }
            }
        }
        
        $this->data['unreviewed'] = $unreviewed;

        return $this->loadTheme('profile.reviews', $this->data);
    }

    // Memproses form simpan ulasan
    public function storeReview(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'order_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = \Modules\Shop\Entities\Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved' // Bisa diubah 'pending' kalau mau di-acc admin dulu
        ]);

        // Notify admin about new review
        $product = \Modules\Shop\Entities\Product::find($request->product_id);
        $user = auth()->user();
        $admins = \App\Models\Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\AdminNotification(
                'Ulasan Baru',
                $user->name . ' memberi ulasan ' . $request->rating . ' bintang untuk ' . ($product->name ?? 'produk') . '.',
                '/admin/products/' . $request->product_id . '/edit'
            ));
        }

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    // Menampilkan halaman Voucher Saya
    // Menampilkan halaman Voucher Saya
    public function vouchers()
    {
        $user = auth()->user();
        
        // 1. Hitung total pesanan pelanggan (untuk mengecek syarat voucher)
        $userOrderCount = \Modules\Shop\Entities\Order::where('user_id', $user->id)
                            ->whereNotIn('status', ['cancelled', 'failed']) // Hanya hitung pesanan yang valid
                            ->count();

        // 2. Ambil semua voucher yang sedang aktif dan belum kadaluarsa
        $allVouchers = \Illuminate\Support\Facades\DB::table('shop_vouchers')
                            ->where('is_active', 1)
                            ->where(function($query) {
                                $query->whereNull('expired_at')
                                        ->orWhere('expired_at', '>=', now());
                            })
                            ->get();

        $availableVouchers = [];
        $lockedVouchers = [];

        // 3. Pisahkan voucher berdasarkan syarat RIWAYAT PESANAN
        foreach ($allVouchers as $voucher) {
            $isEligible = true;
            $reason = '';

            // Syarat 1: Khusus Pengguna Baru
            if ($voucher->is_first_order_only == 1 && $userOrderCount > 0) {
                $isEligible = false;
                $reason = 'Maaf, khusus untuk pelanggan baru.';
            }

            // Syarat 2: Khusus Pesanan ke-N
            if ($voucher->min_order_count > 0) {
                $targetIndex = $voucher->min_order_count - 1; // Contoh: Pesanan ke-3 berarti butuh riwayat 2 pesanan
                
                if ($userOrderCount < $targetIndex) {
                    // Kasus A: Belum memenuhi syarat (Misal butuh pesanan ke-5, tapi riwayat baru 2)
                    $isEligible = false;
                    $sisaBelanja = $targetIndex - $userOrderCount;
                    $reason = 'Terkunci. Belanja ' . $sisaBelanja . ' kali lagi untuk membuka voucher ini.';
                } elseif ($userOrderCount > $targetIndex) {
                    // Kasus B: Sudah kelewatan batas (Misal voucher pesanan ke-3, tapi riwayat sudah 4 pesanan)
                    $isEligible = false;
                    $reason = 'Terkunci. Khusus pesanan ke-' . $voucher->min_order_count . ' kamu.';
                }
            }

            // Masukkan ke array yang sesuai
            if ($isEligible) {
                $availableVouchers[] = $voucher;
            } else {
                $voucher->reason = $reason;
                $lockedVouchers[] = $voucher;
            }
        }

        $this->data['availableVouchers'] = $availableVouchers;
        $this->data['lockedVouchers'] = $lockedVouchers;

        return $this->loadTheme('profile.vouchers', $this->data);
    }
}
