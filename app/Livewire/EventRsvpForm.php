<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventRsvp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class EventRsvpForm extends Component
{
    public Event $event;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public int $numberOfGuests = 1;
    public string $website = '';

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'numberOfGuests' => ['required', 'integer', 'min:1', 'max:4'],
        ];
    }

    private function getRateLimitKey(): string
    {
        return 'event_rsvp:' . request()->ip();
    }

    public function submit(): void
    {
        if (!empty($this->website)) {
            session()->flash('error', 'Invalid submission detected.');
            return;
        }

        $key = $this->getRateLimitKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            session()->flash('error', "Too many RSVP submissions. Please try again in " . ceil($seconds / 60) . " minutes.");
            return;
        }

        if ($this->event->availableSpots() < $this->numberOfGuests) {
            session()->flash('error', 'Sorry, there are not enough spots available for your party size.');
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 3600);

        $rsvpData = [
            'event_id' => $this->event->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'number_of_guests' => $this->numberOfGuests,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        EventRsvp::create($rsvpData);

        $this->sendAdminNotification($rsvpData);
        $this->sendUserConfirmation($rsvpData);

        session()->flash('message', 'Din anmälan är bekräftad! Kolla din e-post för detaljer.');

        $this->reset(['name', 'email', 'phone', 'numberOfGuests']);
    }

    private function sendAdminNotification(array $rsvpData): void
    {
        Mail::raw(
            "New Event RSVP\n\n" .
            "Event: {$this->event->title}\n" .
            "Date: {$this->event->event_date->format('F j, Y')}\n" .
            "Time: {$this->event->start_time}\n\n" .
            "Attendee Details:\n" .
            "Name: {$rsvpData['name']}\n" .
            "Email: {$rsvpData['email']}\n" .
            "Phone: {$rsvpData['phone']}\n" .
            "Number of Guests: {$rsvpData['number_of_guests']}\n\n" .
            "---\n" .
            "Technical Info:\n" .
            "IP: {$rsvpData['ip_address']}\n" .
            "Submitted: " . now() . "\n" .
            "User Agent: {$rsvpData['user_agent']}",
            function ($mail) use ($rsvpData) {
                $mail->to('linda.ettehag@gmail.com')
                    ->subject("New Event RSVP: {$this->event->title}")
                    ->replyTo($rsvpData['email'], $rsvpData['name']);
            }
        );
    }

    private function sendUserConfirmation(array $rsvpData): void
    {
        $message = "Hej {$rsvpData['name']},\n\n" .
            "Tack för din anmälan till vårt evenemang!\n\n" .
            "Evenemangsdetaljer:\n" .
            "Titel: {$this->event->title}\n" .
            "Datum: {$this->event->event_date->locale('sv')->isoFormat('D MMMM YYYY')}\n" .
            "Tid: {$this->event->start_time}" . ($this->event->end_time ? " - {$this->event->end_time}" : "") . "\n" .
            "Plats: {$this->event->street_address}\n" .
            "Antal gäster: {$rsvpData['number_of_guests']}\n\n" .
            "Vi ser fram emot att träffa dig där!\n\n" .
            "---\n\n" .
            "Upptäck mer från oss:\n\n" .
            "📚 Kolla in min första bok \"Fjärilsskugga\" - En fängslande berättelse av Linda Ettehag Kviby.\n" .
            "Besök: https://byekpublishing.com/books\n\n" .
            "🎥 Följ vårt Sicilien-äventyr på YouTube!\n" .
            "Vi dokumenterar vår otroliga resa på Sicilien på vår kanal \"We Bought An Adventure in Sicily\".\n" .
            "Prenumerera: https://www.youtube.com/@WeBoughtAnAdventureInSicily\n\n" .
            "Vänliga hälsningar,\n" .
            "Linda Ettehag Kviby\n" .
            "By Ek Förlag";

        Mail::raw(
            $message,
            function ($mail) use ($rsvpData) {
                $mail->to($rsvpData['email'], $rsvpData['name'])
                    ->subject("Anmälan bekräftad: {$this->event->title}")
                    ->from('linda@byekpublishing.com', 'Linda Ettehag Kviby');
            }
        );
    }

    public function render()
    {
        return view('livewire.event-rsvp-form');
    }
}
