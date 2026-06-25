<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $title;
    protected $message;
    protected $url;

    // 1. Terima data pesanan, judul, isi pesan, dan opsi URL
    public function __construct($order, $title, $message, $url = null)
    {
        $this->order = $order;
        $this->title = $title;
        $this->message = $message;
        
        // Gunakan URL yang diberikan, atau fallback ke URL pelanggan secara relatif
        $this->url = $url ?? '/orders/' . $order->id;
    }

    // 2. Beri tahu Laravel: "Kirim notifikasi ini ke Database saja ya!"
    public function via(object $notifiable): array
    {
        return ['database']; 
    }

    // 3. Susun bentuk data yang akan disimpan ke tabel notifications
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_code' => $this->order->code,
            'title' => $this->title,
            'message' => $this->message,
            // Link URL agar saat lonceng diklik, pelanggan/admin langsung dibawa ke halaman detail pesanan
            'url' => $this->url 
        ];
    }
}