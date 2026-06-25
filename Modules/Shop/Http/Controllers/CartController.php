<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;

use Modules\Shop\Entities\Product;

class CartController extends Controller
{   
    protected $cartRepository;
    protected $productRepository;

    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cart = $this->cartRepository->findByUser(auth()->user());
        $this->data['cart'] = $cart;

        return $this->loadTheme('carts.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('shop::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $productID = $request->get('product_id');
        $qty = $request->get('qty');
        
        $product = $this->productRepository->findByID($productID);
        if (strtoupper($product->type) == 'CONFIGURABLE') {
            if ($request->ajax()) return response()->json(['error' => 'Silakan pilih varian/warna terlebih dahulu']);
            return redirect()->back()->with('error', 'Silakan pilih varian/warna terlebih dahulu');
        }

        if ($product->stock_status != Product::STATUS_IN_STOCK) {
            if ($request->ajax()) return response()->json(['error' => 'Tidak ada stok produk']);
            return redirect()->back()->with('error', 'Tidak ada stok produk');
        }

        if ($product->stock < $qty) {
            if ($request->ajax()) return response()->json(['error' => 'Stok produk tidak mencukupi']);
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
        }

        try {
            $item = $this->cartRepository->addItem($product, $qty);
        } catch (\Exception $e) {
            if ($request->ajax()) return response()->json(['error' => $e->getMessage()]);
            return redirect()->back()->with('error', $e->getMessage());
        }

        if (!$item) {
            if ($request->ajax()) return response()->json(['error' => 'Tidak dapat menambahkan item ke keranjang']);
            return redirect()->back()->with('error', 'Tidak dapat menambahkan item ke keranjang');
        }

        if ($request->ajax()) return response()->json(['success' => 'Berhasil menambahkan item ke keranjang']);
        return redirect()->back()->with('success', 'Berhasil menambahkan item ke keranjang');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('shop::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('shop::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    
    public function update(Request $request)
    {
        $items = $request->get('qty');
        $this->cartRepository->updateQty($items);

        return redirect(route('carts.index'))->with('success', 'Keranjang telah diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->cartRepository->removeItem($id);

        return redirect(route('carts.index'))->with('success', 'Berhasil menghapus item dari keranjang');
    }

    // Jangan lupa tambahkan use Modules\Shop\Entities\voucher; dan use Modules\Shop\Entities\Order; di bagian paling atas file ini

    public function applyvoucher(Request $request)
    {
        $request->validate(['voucher_code' => 'required|string']);

        $code = strtoupper($request->voucher_code);
        $cart = $this->cartRepository->findByUser(auth()->user());
        
        $voucher = \Modules\Shop\Entities\Voucher::where('code', $code)->where('is_active', true)->first();

        if (!$voucher) {
            return response()->json(['status' => 'error', 'message' => 'Kode voucher tidak ditemukan atau sudah tidak aktif.']);
        }

        if ($voucher->expired_at && \Carbon\Carbon::now()->startOfDay()->gt($voucher->expired_at)) {
            return response()->json(['status' => 'error', 'message' => 'Kode voucher ini sudah kedaluwarsa.']);
        }

        if ($cart->base_total_price < $voucher->min_total) {
            return response()->json(['status' => 'error', 'message' => 'Minimal belanja untuk voucher ini adalah Rp ' . number_format($voucher->min_total, 0, ',', '.')]);
        }

        $userOrderCount = \DB::table('shop_orders')
                            ->where('user_id', auth()->id())
                            ->where('status', '!=', 'cancelled')
                            ->count();

        if ($voucher->is_first_order_only && $userOrderCount > 0) {
            return response()->json(['status' => 'error', 'message' => 'Maaf, Voucher ini khusus untuk pelanggan baru.']);
        }

        // OPTION B: Exact match for min_order_count
        if ($voucher->min_order_count > 0 && ($userOrderCount + 1) != $voucher->min_order_count) {
            return response()->json(['status' => 'error', 'message' => 'Voucher ini khusus untuk pesanan ke-' . $voucher->min_order_count . ' kamu.']);
        }

        // Save voucher to cart and let calculateCart do the math
        $cart->voucher_code = $voucher->code;
        $cart->save();
        
        // Reload cart to trigger calculateCart
        $cart = $this->cartRepository->findByUser(auth()->user());

        return response()->json([
            'status' => 'success', 
            'message' => 'Voucher berhasil digunakan!',
            'discount_label' => number_format($cart->discount_amount, 0, ',', '.'), // Note: this includes product discount too, but that's fine or JS can handle it
            'grand_total_label' => number_format($cart->grand_total, 0, ',', '.'),
            'grand_total_raw' => (float) $cart->grand_total,
            'voucher_code' => $cart->voucher_code
        ]);
    }

    public function removevoucher(Request $request)
    {
        $cart = $this->cartRepository->findByUser(auth()->user());
        
        $cart->voucher_code = null;
        $cart->save();
        
        // Reload cart to recalculate without voucher
        $cart = $this->cartRepository->findByUser(auth()->user());

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher berhasil dibatalkan!',
            'discount_label' => number_format($cart->discount_amount, 0, ',', '.'),
            'grand_total_label' => number_format($cart->grand_total, 0, ',', '.'),
            'grand_total_raw' => (float) $cart->grand_total
        ]);
    }
}
