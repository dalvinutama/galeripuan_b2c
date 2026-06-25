<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWishlistPriceDropEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    public $old_price;

    /**
     * Create a new job instance.
     */
    public function __construct($product, $old_price)
    {
        $this->product = $product;
        $this->old_price = $old_price;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $usersToNotify = collect();

        // Get users from Wishlist
        $wishlists = \Modules\Shop\Entities\Wishlist::where('product_id', $this->product->id)->with('user')->get();
        foreach ($wishlists as $wishlist) {
            if ($wishlist->user) {
                $usersToNotify->push($wishlist->user);
            }
        }

        // Get users from Abandoned Carts
        $cartItems = \Modules\Shop\Entities\CartItem::where('product_id', $this->product->id)->with('cart.user')->get();
        foreach ($cartItems as $item) {
            if ($item->cart && $item->cart->user) {
                $usersToNotify->push($item->cart->user);
            }
        }

        // Remove duplicate users
        $uniqueUsers = $usersToNotify->unique('id');

        foreach ($uniqueUsers as $user) {
            // Send email notification
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WishlistPriceDropMail($this->product, $this->old_price));
            
            // Send web (database) notification
            $user->notify(new \App\Notifications\ProductPriceDropNotification($this->product, $this->old_price));
        }
    }
}
