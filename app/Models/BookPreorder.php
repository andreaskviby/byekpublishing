<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;

class BookPreorder extends Model
{
    protected $fillable = [
        'book_id',
        'name',
        'email',
        'phone',
        'street_address',
        'city',
        'postal_code',
        'country',
        'dedication_message',
        'wants_gift_wrap',
        'total_price',
        'payment_status',
        'payment_deadline',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'wants_gift_wrap' => 'boolean',
        'total_price' => 'decimal:2',
        'payment_deadline' => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isPaymentExpired(): bool
    {
        return $this->payment_status === 'pending' && now()->isAfter($this->payment_deadline);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isSent(): bool
    {
        return $this->payment_status === 'sent';
    }

    public function sendPaymentConfirmationEmail(): void
    {
        $giftWrapText = $this->wants_gift_wrap ?
            "\n\n🎁 JULKLAPPSINPACKNING\nBoken kommer att vara inpackad som julklapp." :
            '';

        $dedicationText = $this->dedication_message ?
            "\n\n✍️ DEDIKATION\nBoken kommer att signeras med följande dedikation:\n\"{$this->dedication_message}\"" :
            '';

        $message = "Hej {$this->name},\n\n" .
            "Tack för din betalning! Vi har bekräftat att vi har mottagit {$this->total_price} SEK via Swish.\n\n" .
            "📖 DIN BOKFÖRBESTÄLLNING\n" .
            "Titel: {$this->book->title}\n" .
            "ISBN: {$this->book->isbn}\n" .
            "Order #: {$this->id}\n" .
            "Totalt betalat: {$this->total_price} SEK\n\n" .
            "📦 LEVERANSADRESS\n" .
            "{$this->street_address}\n" .
            "{$this->postal_code} {$this->city}\n" .
            "{$this->country}" .
            $giftWrapText .
            $dedicationText . "\n\n" .
            "✅ NÄSTA STEG\n" .
            "Din förbeställning är nu bekräftad! Boken kommer att skickas till dig så snart den är tillgänglig.\n" .
            "Du kommer att få ett nytt e-postmeddelande med spårningsinformation när boken har skickats.\n\n" .
            "Tack för ditt stöd!\n\n" .
            "---\n\n" .
            "Upptäck mer från oss:\n\n" .
            "📚 Utforska våra böcker på https://byekpublishing.com/books\n\n" .
            "🎥 Följ vårt Sicilien-äventyr på YouTube!\n" .
            "Vi dokumenterar vår otroliga resa på Sicilien.\n" .
            "Prenumerera: https://www.youtube.com/@WeBoughtAnAdventureInSicily\n\n" .
            "Vänliga hälsningar,\n" .
            "Linda Ettehag Kviby\n" .
            "By Ek Förlag\n" .
            "linda@byekpublishing.com";

        Mail::raw(
            $message,
            function ($mail) {
                $mail->to($this->email, $this->name)
                    ->subject("Betalning bekräftad: {$this->book->title}")
                    ->from('linda@byekpublishing.com', 'Linda Ettehag Kviby');
            }
        );
    }

    public function sendShippingConfirmationEmail(): void
    {
        $giftWrapText = $this->wants_gift_wrap ?
            "\n🎁 Inpackad som julklapp" :
            '';

        $dedicationText = $this->dedication_message ?
            "\n✍️ Signerad med dedikation: \"{$this->dedication_message}\"" :
            '';

        $message = "Hej {$this->name},\n\n" .
            "Goda nyheter! Din bok har nu skickats! 📦\n\n" .
            "📖 BOKDETALJER\n" .
            "Titel: {$this->book->title}\n" .
            "Order #: {$this->id}" .
            $giftWrapText .
            $dedicationText . "\n\n" .
            "📦 SKICKAD TILL\n" .
            "{$this->street_address}\n" .
            "{$this->postal_code} {$this->city}\n" .
            "{$this->country}\n\n" .
            "📬 LEVERANSINFORMATION\n" .
            "Boken är nu på väg till dig! Normalt tar leveransen 2-5 arbetsdagar.\n" .
            "Om du har några frågor om din leverans, kontakta oss gärna på linda@byekpublishing.com.\n\n" .
            "Vi hoppas att du kommer att älska boken!\n\n" .
            "---\n\n" .
            "Upptäck mer från oss:\n\n" .
            "📚 Utforska våra böcker på https://byekpublishing.com/books\n\n" .
            "🎥 Följ vårt Sicilien-äventyr på YouTube!\n" .
            "Vi dokumenterar vår otroliga resa på Sicilien.\n" .
            "Prenumerera: https://www.youtube.com/@WeBoughtAnAdventureInSicily\n\n" .
            "Vänliga hälsningar,\n" .
            "Linda Ettehag Kviby\n" .
            "By Ek Förlag\n" .
            "linda@byekpublishing.com";

        Mail::raw(
            $message,
            function ($mail) {
                $mail->to($this->email, $this->name)
                    ->subject("Din bok har skickats: {$this->book->title}")
                    ->from('linda@byekpublishing.com', 'Linda Ettehag Kviby');
            }
        );
    }
}
