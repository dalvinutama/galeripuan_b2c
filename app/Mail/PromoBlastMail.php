<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromoBlastMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject_line;
    public $message_content;
    public $voucher_code;

    /**
     * Create a new message instance.
     */
    public function __construct($subject_line, $message_content, $voucher_code = null)
    {
        $this->subject_line = $subject_line;
        $this->message_content = $message_content;
        $this->voucher_code = $voucher_code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject_line,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.promo',
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
