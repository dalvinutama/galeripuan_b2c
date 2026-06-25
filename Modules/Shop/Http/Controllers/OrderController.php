<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Modules\Shop\Repositories\Front\Interfaces\AddressRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Midtrans\Config; // 
use Midtrans\Snap;
// HAPUS: use Modules\Shop\Repositories\Front\Interfaces\OrderRepositoryInterface;

class OrderController extends Controller
{
    protected $addressRepository;
    protected $cartRepository;
    // HAPUS: protected $orderRepository;

    // HAPUS OrderRepositoryInterface dari dalam kurung di bawah ini
    public function __construct(AddressRepositoryInterface $addressRepository, CartRepositoryInterface $cartRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->cartRepository = $cartRepository;
        // HAPUS: $this->orderRepository = $orderRepository;
    }

   // === TAMBAHKAN Request $request DI SINI AGAR BISA MEMBACA URL ===
    public function checkout(Request $request)
    {
        $cart = $this->cartRepository->findByUser(auth()->user());

        // ==============================================================
        // 1. KODE PENYARING ITEM CHECKOUT (Hanya tampilkan yang dicentang)
        // ==============================================================
        if ($request->has('items') && !empty($request->query('items'))) {
            $selectedIds = explode(',', $request->query('items'));
            
            // Filter: Buang item yang tidak ada di URL
            $cart->items = $cart->items->filter(function ($item) use ($selectedIds) {
                return in_array($item->id, $selectedIds);
            });

            // Hitung ulang uang dan berat KHUSUS untuk barang yang dicentang
            $baseTotal = 0;
            $totalWeight = 0;
            foreach ($cart->items as $item) {
                $price = $item->product->has_sale_price ? $item->product->sale_price : $item->product->price;
                $baseTotal += ($price * $item->qty);
                $weight = $item->product->weight > 0 ? $item->product->weight : 1000; // default 1kg jika kosong
                $totalWeight += ($weight * $item->qty);
            }

            // Timpa angka asli keranjang dengan angka baru hasil saringan
            $cart->base_total_price = $baseTotal;
            $cart->tax_amount = $baseTotal * 0.11; // Pajak 11%
            $cart->grand_total = $cart->base_total_price + $cart->tax_amount - $cart->discount_amount;
            $cart->total_weight = $totalWeight;
        }
        // ==============================================================

        $this->data['cart'] = $cart;
        $this->data['addresses'] = $this->addressRepository->findByUser(auth()->user());

        $user = auth()->user();
        
        $orderCount = \Illuminate\Support\Facades\DB::table('shop_orders')
                        ->where('user_id', $user->id)
                        ->whereNotIn('status', ['cancelled', 'failed']) 
                        ->count();

        $availablevouchers = \Modules\Shop\Entities\voucher::where('is_active', true)
            ->where('expired_at', '>=', now())
            ->get();

        foreach ($availablevouchers as $voucher) {
            $voucher->is_eligible = true;
            $voucher->uneligible_reason = '';

            if ($voucher->is_first_order_only && $orderCount > 0) {
                $voucher->is_eligible = false;
                $voucher->uneligible_reason = 'Maaf, khusus untuk pelanggan baru.';
            } 
            elseif (!$voucher->is_first_order_only && $voucher->min_order_count > 0 && ($orderCount + 1) != $voucher->min_order_count) {
                $voucher->is_eligible = false;
                $voucher->uneligible_reason = 'Terkunci. Khusus pesanan ke-' . $voucher->min_order_count . ' kamu.';
            }
            elseif ($this->data['cart']->base_total_price < $voucher->min_total) {
                $voucher->is_eligible = false;
                $kurang = $voucher->min_total - $this->data['cart']->base_total_price;
                $voucher->uneligible_reason = 'Belanja Rp ' . number_format($kurang, 0, ',', '.') . ' lagi untuk memakai voucher ini.';
            }
        }

        $this->data['vouchers'] = $availablevouchers;
    
        return $this->loadTheme('orders.checkout', $this->data);
    }

    public function shippingFee(Request $request)
    {
        $address = $this->addressRepository->findByID($request->get('address_id'));
        $cart = $this->cartRepository->findByUser(auth()->user());

        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));

        return $this->loadTheme('orders.available_services', ['services' => $availableServices]);
    }

    public function choosePackage(Request $request)
    {
        $address = $this->addressRepository->findByID($request->get('address_id'));
        $cart = $this->cartRepository->findByUser(auth()->user());
        
        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));

        $selectedPackage = null;
        if (!empty($availableServices)) {
            foreach ($availableServices as $service) {
                if ($service['service'] === $request->get('delivery_package')) {
                    $selectedPackage = $service;
                    continue;
                }
            }
        }

        if ($selectedPackage == null) {
            return [];
        }

        return [
            'shipping_fee' => number_format($selectedPackage['cost']),
            'grand_total' => number_format($cart->grand_total + $selectedPackage['cost']),
        ];
    }
    

private function calculateShippingFee($cart, $address, $courier) {
    $baseUrl = rtrim(env('API_ONGKIR_BASE_URL'), '/'); 
    
    try {
        $response = Http::withHeaders([
            'key' => env('API_ONGKIR_KEY'),
        ])->asForm()->post($baseUrl . '/calculate/domestic-cost', [
            'origin'      => env('API_ONGKIR_ORIGIN'),
            'destination' => $address->city_id, // UBAH INI: Pakai city_id (Angka), bukan city (Nama)
            'weight'      => $cart->total_weight > 0 ? $cart->total_weight : 1000, // Pastikan berat tidak 0
            'courier'     => strtolower($courier),
        ]);

        $shippingFees = $response->json();
        $availableServices = [];

        // Format balasan Komerce (data ada di dalam ['data'])
        if (!empty($shippingFees['data'])) {
            foreach ($shippingFees['data'] as $costDetail) {
                $availableServices[] = [
                    'service'     => $costDetail['service'],
                    'description' => $costDetail['description'],
                    'etd'         => empty($costDetail['etd']) ? '-' : $costDetail['etd'],
                    'cost'        => $costDetail['cost'],
                    'courier'     => $courier,
                    'address_id'  => $address->id,
                ];
            }
        }

        return $availableServices;

    } catch (\Exception $e) {
        return [];
    }
}

    public function storeAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'province'   => 'required|string', // Validasi string biasa karena formatnya ID|Nama
            'city'       => 'required|string',
            'address1'   => 'required|string',
            'postcode'   => 'required|numeric',
        ]);

        // Pecah ID dan Nama Provinsi & Kota (Format HTML: "12|Jawa Barat")
        $provData = explode('|', $request->province); 
        $cityData = explode('|', $request->city);

        DB::table('shop_addresses')->where('user_id', auth()->id())->update(['is_primary' => false]);

        DB::table('shop_addresses')->insert([
            'id'          => (string) Str::uuid(),
            'user_id'     => auth()->id(),
            'is_primary'  => true,
            'label'       => $request->label ?? 'Rumah',
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'phone'       => $request->phone,
            'email'       => auth()->user()->email,
            'province_id' => $provData[0], // Ambil ID (Angka)
            'province'    => $provData[1] ?? $provData[0], // Ambil Nama Teks
            'city_id'     => $cityData[0], // Ambil ID (Angka)
            'city'        => $cityData[1] ?? $cityData[0], // Ambil Nama Teks
            'address1'    => $request->address1,
            'address2'    => null,
            'postcode'    => $request->postcode,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'province'   => 'required|string',
            'city'       => 'required|string',
            'address1'   => 'required|string',
            'postcode'   => 'required|numeric',
        ]);

        $provData = explode('|', $request->province); 
        $cityData = explode('|', $request->city);

        DB::table('shop_addresses')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update([
                'label'       => $request->label ?? 'Rumah',
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'phone'       => $request->phone,
                'province_id' => $provData[0],
                'province'    => $provData[1] ?? $provData[0],
                'city_id'     => $cityData[0],
                'city'        => $cityData[1] ?? $cityData[0],
                'address1'    => $request->address1,
                'postcode'    => $request->postcode,
                'updated_at'  => now(),
            ]);

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroyAddress($id)
    {
        // 1. Cari data alamat yang mau dihapus, pastikan milik user yang login
        $address = DB::table('shop_addresses')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        // 2. Jika ketemu, hapus datanya
        if ($address) {
            DB::table('shop_addresses')->where('id', $id)->delete();
            
            // (Opsional Cerdas): Kalau yang dihapus adalah alamat utama (is_primary = 1), 
            // kita jadikan alamat lain (yang paling baru) sebagai alamat utama penggantinya
            if ($address->is_primary == 1) {
                $latestAddress = DB::table('shop_addresses')
                    ->where('user_id', auth()->id())
                    ->latest('created_at')
                    ->first();
                    
                if ($latestAddress) {
                    DB::table('shop_addresses')
                        ->where('id', $latestAddress->id)
                        ->update(['is_primary' => true]);
                }
            }

            return back()->with('success', 'Alamat berhasil dihapus.');
        }

        return back()->with('error', 'Alamat tidak ditemukan atau gagal dihapus.');
    }

public function getProvinces()
    {
        try {
            $apiKey = env('API_ONGKIR_KEY', 'hOLf6WNJ98d317e943a4ebc2lHf2MCRL');
            $url = "https://rajaongkir.komerce.id/api/v1/destination/province";

            $response = Http::withoutVerifying()->withHeaders([
                'key' => $apiKey,
                'Accept' => 'application/json'
            ])->get($url);

            $data = $response->json();

            // Kalau API Komerce kirim error limit, kita kasih tau Javascript
            if (isset($data['meta']) && $data['meta']['code'] != 200) {
                return response()->json(['data' => [], 'error' => $data['meta']['message']]);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack(); 
            
            // KITA PAKSA TAMPILKAN ERROR-NYA DI LAYAR
            dd('MIDTRANS ERROR: ' . $e->getMessage()); 
        }
    }

    public function getCities(Request $request)
    {
        $apiKey = "hOLf6WNJ98d317e943a4ebc2lHf2MCRL";
        $provId = $request->province_id;
        
        // INI KUNCI RAHASIANYA! Ditempel langsung pakai slash (/), BUKAN ?province=
        $url = "https://rajaongkir.komerce.id/api/v1/destination/city/" . $provId;

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'key' => $apiKey,
            'Accept' => 'application/json'
        ])->get($url);

        return response()->json($response->json());
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'address_id' => 'required',
            'courier' => 'required',
            'delivery_package' => 'required',
        ]);

        $cart = $this->cartRepository->findByUser(auth()->user());
        $address = $this->addressRepository->findByID($request->get('address_id'));

        // 2. Hitung Ongkir
        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));
        $selectedPackage = null;
        foreach ($availableServices as $service) {
            if ($service['service'] === $request->get('delivery_package')) {
                $selectedPackage = $service;
                break;
            }
        }

        if (!$selectedPackage) {
            return back()->with('error', 'Layanan pengiriman tidak valid!');
        }

        // 3. Siapkan Data
        $grandTotal = $cart->grand_total + $selectedPackage['cost'];
        $orderCode = 'INV-' . time();
        $orderId = (string) Str::uuid();

        // ======================================================
        // 4. MIDTRANS: MINTA SNAP TOKEN
        // ======================================================
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $midtransParams = [
            'transaction_details' => [
                'order_id' => $orderCode,
                'gross_amount' => $grandTotal,
            ],
            'customer_details' => [
                'first_name' => $address->first_name,
                'last_name' => $address->last_name,
                'email' => auth()->user()->email,
                'phone' => $address->phone,
            ],
        ];

        DB::beginTransaction(); // Mulai transaksi database biar aman
        try {
            // Minta Token ke Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);

            // ======================================================
            // 5. SIMPAN KE DATABASE (SESUAI TABELMU)
            // ======================================================
            
            // Simpan ke shop_orders
            // Simpan ke shop_orders
            DB::table('shop_orders')->insert([
                'id' => $orderId,
                'user_id' => auth()->id(),
                'code' => $orderCode,
                'status' => 'created',
                'order_date' => now(),
                'payment_due' => now()->addDays(1),
                'payment_status' => 'unpaid',
                'base_total_price' => $cart->base_total_price,
                'tax_amount' => $cart->tax_amount,
                'discount_amount' => $cart->discount_amount,
                'voucher_code' => $cart->voucher_code,
                'shipping_cost' => $selectedPackage['cost'],
                'grand_total' => $grandTotal,
                // --- INI TAMBAHANNYA ---
                'customer_first_name' => $address->first_name,
                'customer_last_name'  => $address->last_name,  // Ditambahkan
                'customer_email'      => auth()->user()->email,
                'customer_phone'      => $address->phone,      // Ditambahkan
                'customer_address1'   => $address->address1,   // Ditambahkan
                'customer_address2'   => $address->address2,   // Ditambahkan (Opsional, boleh ada/tidak)
                'customer_city'       => $address->city,       // Ditambahkan
                'customer_province'   => $address->province,   // Ditambahkan
                'customer_postcode'   => $address->postcode,   // Ditambahkan
                // -----------------------
                'shipping_courier' => $request->get('courier'),
                'shipping_service_name' => $selectedPackage['service'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // PINDAHKAN BARANG DARI KERANJANG KE ORDER_ITEMS
            $cartItems = DB::table('shop_cart_items')->where('cart_id', $cart->id)->get();
            foreach ($cartItems as $item) {
                // Ambil data produk 
                $product = DB::table('shop_products')->where('id', $item->product_id)->first();
                
                // Kalkulasi Harga per item
                $itemBasePrice = $product->price;
                $itemSalePrice = $product->sale_price;
                $itemPrice = ($itemSalePrice > 0) ? $itemSalePrice : $itemBasePrice;
                $itemDiscountAmount = ($itemSalePrice > 0) ? ($itemBasePrice - $itemSalePrice) : 0;
                $itemDiscountPercent = ($itemSalePrice > 0 && $itemBasePrice > 0) ? (($itemDiscountAmount / $itemBasePrice) * 100) : 0;
                $taxPercent = 0.11; // 11% standard
                $itemTaxAmount = $itemPrice * $taxPercent;

                DB::table('shop_order_items')->insert([
                    'id'               => (string) Str::uuid(),
                    'order_id'         => $orderId,
                    'product_id'       => $item->product_id,
                    
                    // Identitas Barang
                    'sku'              => $product->sku ?? 'NO-SKU',
                    'type'             => $product->type ?? 'simple',
                    'name'             => $product->name,
                    'attributes'       => $item->attributes ?? '[]',
                    
                    // Kalkulasi Harga
                    'qty'              => $item->qty,
                    'base_price'       => $itemBasePrice,
                    'base_total'       => $itemBasePrice * $item->qty,
                    'tax_amount'       => $itemTaxAmount * $item->qty, 
                    'tax_percent'      => $taxPercent * 100,
                    'discount_amount'  => $itemDiscountAmount * $item->qty,
                    'discount_percent' => $itemDiscountPercent,
                    'sub_total'        => $itemPrice * $item->qty,
                    
                    // Waktu
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            // Simpan ke shop_payments
            // Simpan ke shop_payments
            DB::table('shop_payments')->insert([
                'id'           => (string) Str::uuid(),
                'user_id'      => auth()->id(), // WAJIB ADA! (Ketahuan dari screenshot phpMyAdmin)
                'order_id'     => $orderId,
                'payment_type' => 'midtrans',
                'status'       => 'pending',
                'amount'       => $grandTotal,
                'token'        => $snapToken,   // Sekarang sudah aman karena kolomnya sudah kita buat
                'payloads'     => json_encode($midtransParams),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // Hapus Keranjang
            // ... (Kodingan atasnya biarkan saja, sudah benar)

            // 6. Hapus Keranjang (URUTANNYA DIBALIK BIAR TIDAK ERROR DATABASE)
            DB::table('shop_cart_items')->where('cart_id', $cart->id)->delete(); // Hapus isinya dulu
            DB::table('shop_carts')->where('id', $cart->id)->delete(); // Baru hapus keranjangnya

            DB::commit(); // Transaksi sukses!

            // --- TAMBAHAN NOTIFIKASI PESANAN BARU MASUK KE ADMIN ---
            $newOrderData = \Illuminate\Support\Facades\DB::table('shop_orders')->where('id', $orderId)->first();
            if ($newOrderData) {
                $admins = \App\Models\Admin::all();
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\OrderStatusNotification($newOrderData, 'Pesanan Baru', "Ada pesanan baru #{$newOrderData->code} masuk dan menunggu pembayaran.", '/admin/orders/' . $newOrderData->id));
                }
            }
            // --------------------------------------------------------

            // KITA ARAHKAN PENGGUNA KE HALAMAN DETAIL PESANAN
            // (Pakai $orderId, BUKAN $order->id)
            return redirect()->route('orders.show', $orderId)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua simpanan kalau ada yang error
            
            // Kembalikan ke halaman sebelumnya dan bawa pesan error aslinya
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    } // Akhir dari fungsi store()

    public function show($id)
    {
        $order = \Modules\Shop\Entities\Order::with(['items.product.images', 'returnClaim'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $payment = DB::table('shop_payments')->where('order_id', $id)->first();

        $orderItems = DB::table('shop_order_items')
            ->join('shop_products', 'shop_order_items.product_id', '=', 'shop_products.id')
            ->where('shop_order_items.order_id', $id)
            ->select('shop_order_items.*', 'shop_products.name as product_name')
            ->get();

        $this->data['order'] = $order;
        $this->data['payment'] = $payment;
        $this->data['orderItems'] = $orderItems;

        return $this->loadTheme('orders.show', $this->data);
    }

    public function callback(Request $request)
    {
        // 1. KAMERA PENGINTAI: Catat semua data yang dikirim Midtrans ke laravel.log
        \Illuminate\Support\Facades\Log::info('=== SURAT DARI MIDTRANS MASUK ===', $request->all());

        $serverKey = config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        $grossAmount = $request->gross_amount;
        $hashed = hash("sha512", $request->order_id . $request->status_code . $grossAmount . $serverKey);

        if ($hashed == $request->signature_key) {
            // Catat ke log bahwa kunci cocok
            \Illuminate\Support\Facades\Log::info('KUNCI COCOK! Status Transaksi: ' . $request->transaction_status);
            
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // Coba update databasenya
                $updateOrder = \Illuminate\Support\Facades\DB::table('shop_orders')
                    ->where('code', $request->order_id)
                    ->update([
                        'payment_status' => 'paid',
                        'status' => 'processing'
                    ]);
                
                // --- TAMBAHAN NOTIFIKASI BAYAR ---
                $orderData = \Illuminate\Support\Facades\DB::table('shop_orders')->where('code', $request->order_id)->first();
                if ($orderData) {
                    // Kurangi Stok secara realtime via Model Order
                    $orderModel = \Modules\Shop\Entities\Order::find($orderData->id);
                    if ($orderModel) {
                        $orderModel->reduceStock();
                    }

                    $user = \App\Models\User::find($orderData->user_id);
                    if ($user) {
                        $user->notify(new \App\Notifications\OrderStatusNotification($orderData, 'Pembayaran Berhasil', "Hore! Pembayaran untuk pesanan #{$orderData->code} telah kami terima."));
                    }
                    
                    $admins = \App\Models\Admin::all();
                    foreach ($admins as $admin) {
                        $admin->notify(new \App\Notifications\OrderStatusNotification($orderData, 'Pesanan Baru Dibayar', "Pesanan #{$orderData->code} telah dibayar dan siap untuk diproses.", '/admin/orders/' . $orderData->id));
                    }
                }
                // ---------------------------------
                
                // Catat apakah databasenya beneran ter-update atau malah 0 baris
                \Illuminate\Support\Facades\Log::info('Jumlah baris pesanan yang sukses diupdate: ' . $updateOrder);

                \Illuminate\Support\Facades\DB::table('shop_payments')
                    ->whereIn('order_id', function($query) use ($request) {
                        $query->select('id')->from('shop_orders')->where('code', $request->order_id);
                    })
                    ->update(['status' => 'settlement']);

            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                \Illuminate\Support\Facades\DB::table('shop_orders')
                    ->where('code', $request->order_id)
                    ->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled'
                    ]);
                
                // --- TAMBAHAN NOTIFIKASI BATAL DARI MIDTRANS ---
                $orderData = \Illuminate\Support\Facades\DB::table('shop_orders')->where('code', $request->order_id)->first();
                if ($orderData) {
                    $user = \App\Models\User::find($orderData->user_id);
                    if ($user) {
                        $user->notify(new \App\Notifications\OrderStatusNotification($orderData, 'Pesanan Dibatalkan', "Maaf, pesanan #{$orderData->code} dibatalkan karena waktu pembayaran habis."));
                    }
                    
                    $admins = \App\Models\Admin::all();
                    foreach ($admins as $admin) {
                        $admin->notify(new \App\Notifications\OrderStatusNotification($orderData, 'Pesanan Gagal', "Pesanan #{$orderData->code} gagal dibayar atau dibatalkan otomatis.", '/admin/orders/' . $orderData->id));
                    }
                }
                // -----------------------------------------------
            }

            return response()->json(['message' => 'Notifikasi berhasil diproses'], 200);
        }

        \Illuminate\Support\Facades\Log::error('MIDTRANS HASH GAGAL. Kunci tidak cocok.');
        return response()->json(['message' => 'Kunci tidak valid'], 403);
    }
    public function index(Request $request)
    {
        // 1. Tangkap status dari link URL
        $status = $request->query('status');

        // 2. Siapkan query dasar: Ambil pesanan milik user ini, urutkan dari yang terbaru
        $query = \Modules\Shop\Entities\Order::with(['items.product.images'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        // 3. FILTERING: Saring data berdasarkan tab yang diklik
        if ($status == 'unpaid') {
            $query->whereIn('status', ['created', 'unpaid', 'pending']); 
        } elseif ($status == 'dikemas') {
            $query->whereIn('status', ['processing', 'packaging', 'confirmed']); 
        } elseif ($status == 'dikirim') {
            $query->whereIn('status', ['delivered', 'shipped']); 
        } elseif ($status == 'selesai') {
            $query->whereIn('status', ['received', 'completed']); 
        } elseif ($status == 'dibatalkan') {
            // INI KUNCI AGAR TAB DIBATALKAN HANYA MUNCUL STATUS CANCELLED
            $query->where('status', 'cancelled'); 
        }

        // 4. Eksekusi query (Data BARU DIAMBIL setelah disaring di atas)
        $orders = $query->get();

        $this->data['orders'] = $orders;
        $this->data['currentStatus'] = $status; 

        return $this->loadTheme('orders.index', $this->data);
    }
    public function cancel($id)
    {
        // 1. Cari pesanan milik pelanggan yang sedang login
        $order = DB::table('shop_orders')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // 2. Cek apakah umurnya sudah lewat 24 jam atau sudah dibayar
        $isExpired = \Carbon\Carbon::parse($order->created_at)->addHours(24)->isPast();
        $isUnpaid = in_array($order->status, ['created', 'unpaid', 'pending']);

        // 3. Hanya boleh dibatalkan JIKA belum dibayar DAN belum kedaluwarsa
        if ($isUnpaid && !$isExpired) {
            DB::table('shop_orders')
                ->where('id', $id)
                ->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed',
                    'updated_at' => now()
                ]);

            // --- TAMBAHAN NOTIFIKASI BATAL KE ADMIN ---
            $admins = \App\Models\Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Dibatalkan', "Pesanan #{$order->code} telah dibatalkan oleh pelanggan.", '/admin/orders/' . $order->id));
            }
            // ------------------------------------------

            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Maaf, pesanan yang sudah dibayar atau kedaluwarsa tidak dapat dibatalkan.');
    }

    public function complete($id)
    {
        $order = \Illuminate\Support\Facades\DB::table('shop_orders')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($order && in_array(strtolower($order->status), ['delivered', 'shipped'])) {
            \Illuminate\Support\Facades\DB::table('shop_orders')
                ->where('id', $id)
                ->update([
                    'status' => 'completed',
                    'updated_at' => now()
                ]);

            // --- KIRIM NOTIFIKASI KE PELANGGAN ---
            $user = \App\Models\User::find(auth()->id());
            $user->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Selesai', "Hore! Pesanan #{$order->code} telah selesai. Jangan lupa beri ulasan ya!"));
            // -------------------------------------

            // --- KIRIM NOTIFIKASI KE ADMIN ---
            $admins = \App\Models\Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\OrderStatusNotification($order, 'Pesanan Selesai', "Pesanan #{$order->code} telah dikonfirmasi selesai oleh pelanggan.", '/admin/orders/' . $order->id));
            }
            // ----------------------------------

            return back()->with('success', 'Terima kasih! Pesanan telah dikonfirmasi selesai.');
        }

        return back()->with('error', 'Pesanan tidak valid untuk diselesaikan.');
    }
}
