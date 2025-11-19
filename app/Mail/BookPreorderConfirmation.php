<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\BookPreorder;
use App\Services\SwishQrService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookPreorderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $qrCodeData = null;

    public function __construct(
        public BookPreorder $preorder,
        public Book $book
    ) {
        $this->qrCodeData = SwishQrService::generateQrCode(
            amount: $this->preorder->total_price,
            message: "Förbeställning #{$this->preorder->id}",
            format: 'png',
            size: 300
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Förbeställning bekräftad: {$this->book->title}",
            from: 'linda@byekpublishing.com',
            replyTo: 'linda@byekpublishing.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-preorder-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
