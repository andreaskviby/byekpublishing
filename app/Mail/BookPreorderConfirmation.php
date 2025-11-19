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

    public ?string $qrCodeUrl = null;
    public string $swishPaymentUrl;

    public function __construct(
        public BookPreorder $preorder,
        public Book $book
    ) {
        $filename = SwishQrService::generateAndSaveQrCode(
            amount: $this->preorder->total_price,
            message: "Förbeställning #{$this->preorder->id}",
            identifier: "preorder-{$this->preorder->id}",
            format: 'png',
            size: 300
        );

        $this->qrCodeUrl = SwishQrService::getPublicUrl($filename);

        $this->swishPaymentUrl = SwishQrService::generatePaymentUrl(
            amount: $this->preorder->total_price,
            message: "Förbeställning #{$this->preorder->id}"
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
