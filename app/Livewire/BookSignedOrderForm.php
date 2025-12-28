<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookPreorder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class BookSignedOrderForm extends Component
{
    public const SHIPPING_COST = 55;

    public Book $book;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $streetAddress = '';
    public string $city = '';
    public string $postalCode = '';
    public string $country = 'Sverige';
    public string $dedicationMessage = '';
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
        ];
    }

    private function getRateLimitKey(): string
    {
        return 'book_signed_order:' . request()->ip();
    }

    public function submit(): void
    {
        if (!empty($this->website)) {
            session()->flash('error', 'Ogiltig begaran upptackt.');
            return;
        }

        $key = $this->getRateLimitKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            session()->flash('error', "For manga bestallningsforsok. Forsok igen om " . ceil($seconds / 60) . " minuter.");
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 3600);

        $shippingCost = self::SHIPPING_COST;
        $totalPrice = $this->book->price + $shippingCost;
        $paymentDeadline = now()->addHours(2);

        $orderData = [
            'book_id' => $this->book->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'street_address' => $this->streetAddress,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'country' => $this->country,
            'dedication_message' => $this->dedicationMessage,
            'wants_gift_wrap' => false,
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
            'payment_deadline' => $paymentDeadline,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        $order = BookPreorder::create($orderData);

        $this->sendAdminNotification($order);
        $this->sendUserConfirmation($order);

        session()->flash('message', 'Din bestallning ar registrerad! Kolla din e-post for betalningsinstruktioner.');

        $this->reset(['name', 'email', 'phone', 'streetAddress', 'city', 'postalCode', 'dedicationMessage']);
    }

    private function sendAdminNotification(BookPreorder $order): void
    {
        $dedicationText = $order->dedication_message ? "\nDedikation: {$order->dedication_message}" : '';
        $shippingCost = self::SHIPPING_COST;

        Mail::raw(
            "Ny Bokbestallning (Signerad)\n\n" .
            "Bok: {$this->book->title}\n" .
            "ISBN: {$this->book->isbn}\n\n" .
            "Kunduppgifter:\n" .
            "Namn: {$order->name}\n" .
            "E-post: {$order->email}\n" .
            "Telefon: {$order->phone}\n\n" .
            "Leveransadress:\n" .
            "{$order->street_address}\n" .
            "{$order->postal_code} {$order->city}\n" .
            "{$order->country}\n\n" .
            "Bestallningsdetaljer:\n" .
            "Signerad bok: Ja" .
            "{$dedicationText}\n" .
            "Bokpris: {$this->book->price} SEK\n" .
            "Frakt: {$shippingCost} SEK\n" .
            "Totalpris: {$order->total_price} SEK\n\n" .
            "Betalningsinformation:\n" .
            "Status: Vantar pa betalning\n" .
            "Deadline: {$order->payment_deadline->format('Y-m-d H:i')}\n\n" .
            "---\n" .
            "Teknisk info:\n" .
            "IP: {$order->ip_address}\n" .
            "Registrerad: " . now() . "\n" .
            "User Agent: {$order->user_agent}",
            function ($mail) use ($order) {
                $mail->to('linda.ettehag@gmail.com')
                    ->subject("Ny bokbestallning (signerad): {$this->book->title}")
                    ->replyTo($order->email, $order->name);
            }
        );
    }

    private function sendUserConfirmation(BookPreorder $order): void
    {
        Mail::to($order->email, $order->name)
            ->send(new \App\Mail\BookSignedOrderConfirmation($order, $this->book));
    }

    public function getShippingCost(): int
    {
        return self::SHIPPING_COST;
    }

    public function getTotalPrice(): int
    {
        return $this->book->price + self::SHIPPING_COST;
    }

    public function render()
    {
        return view('livewire.book-signed-order-form', [
            'shippingCost' => self::SHIPPING_COST,
            'totalPrice' => $this->book->price + self::SHIPPING_COST,
        ]);
    }
}
