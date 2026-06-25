<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Voucher;

class AfterSalesCareMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;
    public Voucher $voucher;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Voucher $voucher)
    {
        $this->order   = $order;
        $this->voucher = $voucher;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✨ Terima Kasih, ' . $this->order->customer_first_name . '! Hadiah Spesial Dari Gallery Puan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.after-sales-care',
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
