<?php

namespace Modules\Shop\Repositories\Front;

use App\Models\User;
use Carbon\Carbon;
use Modules\Shop\Entities\Cart;
use Modules\Shop\Entities\CartItem;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\Voucher;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{

    public function findByUser(User $user): Cart
    {
        $cart = Cart::with([
            'items',
            'items.product',
        ])->forUser($user)->first();

        if (!$cart) {
            return Cart::create([
                'user_id' => $user->id,
                'expired_at' => (new Carbon())->addDay(7),
            ]);
        }

        $this->calculateCart($cart);

        return $cart;
    }

    public function addItem(Product $product, $qty): CartItem
    {
        $cart = $this->findByUser(auth()->user());

        $existItem = CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ])->first();

        if (!$existItem) {
            return CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'attributes' => $product->attributes ?? [],
            ]);
        }

        if (($existItem->qty + $qty) > $product->stock) {
            throw new \Exception('Stok produk tidak mencukupi untuk jumlah yang diminta.');
        }

        $existItem->qty = $existItem->qty + $qty;
        $existItem->save();

        return $existItem;
    }

    public function removeItem($id) : bool
    {
        return CartItem::where('id', $id)->delete();
    }

    public function updateQty($items = []): void
    {
        if (!empty($items)) {
            foreach ($items as $itemID => $qty) {
                $item = CartItem::where('id', $itemID)->first();
                if ($item) {
                    $item->qty = $qty;
                    $item->save();
                }
            }
        }
    }

    private function calculateCart(Cart $cart): void
    {
        $baseTotalPrice = 0;
        $productDiscountAmount = 0;
        $totalWeight = 0;

        if (count($cart->items) > 0) {
            foreach ($cart->items as $item) {
                $baseTotalPrice += $item->qty * $item->product->price;

                if ($item->product->has_sale_price) {
                    $discountAmountItem = $item->product->price - $item->product->sale_price;
                    $productDiscountAmount += $item->qty * $discountAmountItem;
                }
                $totalWeight += ($item->qty * $item->product->weight);
            }
        }

        $nettTotal = $baseTotalPrice - $productDiscountAmount;
        $taxAmount = 0.11 * $nettTotal;
        $grandTotal = $nettTotal + $taxAmount;

        // --- VOUCHER LOGIC ---
        $voucherDiscountAmount = 0;
        $voucherDiscountPercent = 0;
        
        if ($cart->voucher_code) {
            $voucher = Voucher::where('code', $cart->voucher_code)->where('is_active', true)->first();
            $isEligible = false;
            
            if ($voucher && (!$voucher->expired_at || \Carbon\Carbon::now()->startOfDay()->lte($voucher->expired_at))) {
                if ($baseTotalPrice >= $voucher->min_total) {
                    $userOrderCount = \Illuminate\Support\Facades\DB::table('shop_orders')
                            ->where('user_id', $cart->user_id)
                            ->whereNotIn('status', ['cancelled', 'failed'])
                            ->count();
                            
                    $isEligible = true;
                    if ($voucher->is_first_order_only && $userOrderCount > 0) {
                        $isEligible = false;
                    } elseif (!$voucher->is_first_order_only && $voucher->min_order_count > 0 && ($userOrderCount + 1) != $voucher->min_order_count) {
                        $isEligible = false;
                    }
                    
                    if ($isEligible) {
                        if ($voucher->type == 'fixed') {
                            $voucherDiscountAmount = $voucher->value;
                        } else {
                            $voucherDiscountPercent = $voucher->value;
                            $voucherDiscountAmount = ($baseTotalPrice * $voucher->value) / 100;
                        }
                    }
                }
            }
            
            if (!$isEligible) {
                $cart->voucher_code = null;
            }
        }
        
        if ($voucherDiscountAmount > $grandTotal) {
            $voucherDiscountAmount = $grandTotal;
        }
        
        $grandTotal -= $voucherDiscountAmount;
        $totalDiscountAmount = $productDiscountAmount + $voucherDiscountAmount;

        $cart->update([
            'base_total_price' => $baseTotalPrice,
            'tax_amount' => $taxAmount,
            'discount_amount' => $totalDiscountAmount,
            'discount_percent' => $voucherDiscountPercent,
            'grand_total' => $grandTotal,
            'total_weight' => $totalWeight,
            'voucher_code' => $cart->voucher_code
        ]);
    }
}