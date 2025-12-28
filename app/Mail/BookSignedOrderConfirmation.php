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

class BookSignedOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $qrCodeUrl = null;
    public string $swishPaymentUrl;
    public int $shippingCost;

    public function __construct(
        public BookPreorder $order,
        public Book $book
    ) {
        $this->shippingCost = $this->book->getEffectiveShippingCost();
        $filename = SwishQrService::generateAndSaveQrCode(
            amount: $this->order->total_price,
            message: "Bestallning #{$this->order->id}",
            identifier: "order-{$this->order->id}",
            format: 'png',
            size: 300
        );

        $this->qrCodeUrl = SwishQrService::getPublicUrl($filename);

        $this->swishPaymentUrl = SwishQrService::generatePaymentUrl(
            amount: $this->order->total_price,
            message: "Bestallning #{$this->order->id}"
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Bestallning bekraftad: {$this->book->title} (signerad)",
            from: 'linda@byekpublishing.com',
            replyTo: 'linda@byekpublishing.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-signed-order-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
