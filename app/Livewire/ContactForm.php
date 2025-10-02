<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

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
            'message' => ['required', 'string', 'min:10'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        // Save message to database
        Message::create($validated);

        // Send email notification
        Mail::raw(
            "Name: {$validated['name']}\nEmail: {$validated['email']}\n\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to('linda.ettehag@gmail.com')
                    ->subject("Contact Form: {$validated['subject']}")
                    ->replyTo($validated['email'], $validated['name']);
            }
        );

        session()->flash('message', 'Thank you for your message! Linda will get back to you soon.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-form')->layout('layouts.app')->title('Contact');
    }
}
