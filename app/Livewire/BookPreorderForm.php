<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookPreorder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class BookPreorderForm extends Component
{
    public Book $book;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $streetAddress = '';
    public string $city = '';
    public string $postalCode = '';
    public string $country = 'Sverige';
    public string $dedicationMessage = '';
    public bool $wantsGiftWrap = false;
    public string $website = '';

    public function mount(Book $book): void
    {
        $this->book = $book;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'streetAddress' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postalCode' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'dedicationMessage' => ['nullable', 'string', 'max:500'],
            'wantsGiftWrap' => ['boolean'],
        ];
    }

    private function getRateLimitKey(): string
    {
        return 'book_preorder:' . request()->ip();
    }

    public function updatedWantsGiftWrap(): void
    {
        $this->dispatch('gift-wrap-updated', wantsGiftWrap: $this->wantsGiftWrap);
    }

    public function submit(): void
    {
        if (!empty($this->website)) {
            session()->flash('error', 'Ogiltig förfrågan upptäckt.');
            return;
        }

        $key = $this->getRateLimitKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            session()->flash('error', "För många förbeställningsförsök. Försök igen om " . ceil($seconds / 60) . " minuter.");
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 3600);

        $giftWrapPrice = 49;
        $totalPrice = $this->book->price + ($this->wantsGiftWrap ? $giftWrapPrice : 0);
        $paymentDeadline = now()->addHours(2);

        $preorderData = [
            'book_id' => $this->book->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'street_address' => $this->streetAddress,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'country' => $this->country,
            'dedication_message' => $this->dedicationMessage,
            'wants_gift_wrap' => $this->wantsGiftWrap,
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
            'payment_deadline' => $paymentDeadline,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        $preorder = BookPreorder::create($preorderData);

        $this->sendAdminNotification($preorder);
        $this->sendUserConfirmation($preorder);

        session()->flash('message', 'Din förbeställning är registrerad! Kolla din e-post för betalningsinstruktioner.');

        $this->reset(['name', 'email', 'phone', 'streetAddress', 'city', 'postalCode', 'dedicationMessage', 'wantsGiftWrap']);
    }

    private function sendAdminNotification(BookPreorder $preorder): void
    {
        $giftWrapText = $preorder->wants_gift_wrap ? 'Ja (+49 SEK)' : 'Nej';
        $dedicationText = $preorder->dedication_message ? "\nDedikation: {$preorder->dedication_message}" : '';

        Mail::raw(
            "Ny Bokförbeställning\n\n" .
            "Bok: {$this->book->title}\n" .
            "ISBN: {$this->book->isbn}\n\n" .
            "Kunduppgifter:\n" .
            "Namn: {$preorder->name}\n" .
            "E-post: {$preorder->email}\n" .
            "Telefon: {$preorder->phone}\n\n" .
            "Leveransadress:\n" .
            "{$preorder->street_address}\n" .
            "{$preorder->postal_code} {$preorder->city}\n" .
            "{$preorder->country}\n\n" .
            "Beställningsdetaljer:\n" .
            "Julklappsinpackning: {$giftWrapText}" .
            "{$dedicationText}\n" .
            "Totalpris: {$preorder->total_price} SEK\n\n" .
            "Betalningsinformation:\n" .
            "Status: Väntar på betalning\n" .
            "Deadline: {$preorder->payment_deadline->format('Y-m-d H:i')}\n\n" .
            "---\n" .
            "Teknisk info:\n" .
            "IP: {$preorder->ip_address}\n" .
            "Registrerad: " . now() . "\n" .
            "User Agent: {$preorder->user_agent}",
            function ($mail) use ($preorder) {
                $mail->to('linda.ettehag@gmail.com')
                    ->subject("Ny bokförbeställning: {$this->book->title}")
                    ->replyTo($preorder->email, $preorder->name);
            }
        );
    }

    private function sendUserConfirmation(BookPreorder $preorder): void
    {
        Mail::to($preorder->email, $preorder->name)
            ->send(new \App\Mail\BookPreorderConfirmation($preorder, $this->book));
    }

    public function render()
    {
        return view('livewire.book-preorder-form');
    }
}
