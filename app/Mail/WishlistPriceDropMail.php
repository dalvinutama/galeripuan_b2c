<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WishlistPriceDropMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;
    public $old_price;

    /**
     * Create a new message instance.
     */
    public function __construct($product, $old_price)
    {
        $this->product = $product;
        $this->old_price = $old_price;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kabar Gembira! Produk impianmu sedang Diskon! 🎉',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.wishlist_price_drop',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
