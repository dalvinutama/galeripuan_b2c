<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductPriceDropNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $oldPrice;

    public function __construct($product, $oldPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
    }

    public function via(object $notifiable): array
    {
        return ['database']; 
    }

    public function toArray(object $notifiable): array
    {
        $salePriceFormatted = number_format($this->product->sale_price, 0, ',', '.');
        return [
            'title' => 'Diskon Produk Favoritmu! 🎉',
            'message' => "Hore! Harga {$this->product->name} turun menjadi Rp {$salePriceFormatted}. Yuk checkout sekarang!",
            'url' => '/product/' . $this->product->slug
        ];
    }
}
