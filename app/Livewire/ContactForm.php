<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';
    
    // Anti-spam honeypot (should remain empty)
    public string $website = '';

    public function mount(): void
    {
        if (request()->has('art')) {
            $this->message = 'I am interested in ' . request()->get('art');
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    // Rate limiting key
    private function getRateLimitKey(): string
    {
        return 'contact_form:' . request()->ip();
    }

    public function submit(): void
    {
        // Honeypot spam check
        if (!empty($this->website)) {
            session()->flash('error', 'Invalid submission detected.');
            return;
        }

        // Rate limiting - max 5 submissions per IP per hour
        $key = $this->getRateLimitKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            session()->flash('error', "Too many contact form submissions. Please try again in " . ceil($seconds / 60) . " minutes.");
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 3600); // 1 hour

        // Enhanced message data with anti-spam info
        $messageData = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'submitted_at' => now(),
        ];

        // Save message to database
        Message::create($messageData);

        // Send email notification with enhanced spam protection info
        Mail::raw(
            "New Contact Form Submission\n\n" .
            "Name: {$messageData['name']}\n" .
            "Email: {$messageData['email']}\n" .
            "Subject: {$messageData['subject']}\n\n" .
            "Message:\n{$messageData['message']}\n\n" .
            "---\n" .
            "Technical Info:\n" .
            "IP: {$messageData['ip_address']}\n" .
            "Submitted: {$messageData['submitted_at']}\n" .
            "User Agent: {$messageData['user_agent']}",
            function ($mail) use ($messageData) {
                $mail->to('linda.ettehag@gmail.com')
                    ->subject("Contact Form: {$messageData['subject']}")
                    ->replyTo($messageData['email'], $messageData['name']);
            }
        );

        session()->flash('message', 'Thank you for your message! Linda will get back to you soon.');

        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form')->layout('layouts.app')->title('Contact');
    }
}
