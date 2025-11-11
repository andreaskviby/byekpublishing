<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookReview;
use App\Models\Language;
use App\Models\NewsletterSubscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\Attributes\Validate;

class BookReviewForm extends Component
{
    public Book $book;
    
    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 0;
    
    #[Validate('nullable|string|max:1000')]
    public string $reviewText = '';
    
    #[Validate('nullable|string|max:100')]
    public string $signature = '';
    
    #[Validate('nullable|email|max:255')]
    public string $email = '';
    
    #[Validate('nullable|string|max:100')]
    public string $name = '';
    
    public bool $subscribeToNewsletter = false;
    public bool $showNewsletterFields = false;
    
    // Anti-spam honeypot (should remain empty)
    public string $website = '';
    
    // Rate limiting key
    private function getRateLimitKey(): string
    {
        return 'review_submission:' . request()->ip();
    }

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    public function updatedSubscribeToNewsletter()
    {
        $this->showNewsletterFields = $this->subscribeToNewsletter;
        if (!$this->subscribeToNewsletter) {
            $this->name = '';
            $this->email = '';
        }
    }

    public function submitReview()
    {
        // Honeypot spam check
        if (!empty($this->website)) {
            session()->flash('error', 'Invalid submission detected.');
            return;
        }

        // Rate limiting - max 3 reviews per IP per hour
        $key = $this->getRateLimitKey();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            session()->flash('error', "Too many review submissions. Please try again in " . ceil($seconds / 60) . " minutes.");
            return;
        }

        // Additional validation for newsletter subscription
        if ($this->subscribeToNewsletter) {
            $this->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:255',
            ]);
        }

        $this->validate();

        RateLimiter::hit($key, 3600); // 1 hour

        // Get the default language or first available language
        $language = Language::first();
        
        // Create review
        $review = BookReview::create([
            'book_id' => $this->book->id,
            'language_id' => $language->id,
            'rating' => $this->rating,
            'review_text' => $this->reviewText ?: null,
            'reviewer_signature' => $this->signature ?: null,
            'reviewer_email' => $this->email ?: null,
            'subscribed_to_newsletter' => $this->subscribeToNewsletter,
        ]);

        // Generate verification token if email provided
        if ($this->email) {
            $verificationToken = $review->generateVerificationToken();
            $this->sendVerificationEmail($review, $verificationToken);
        } else {
            // If no email, mark as verified (but still needs admin approval)
            $review->markAsVerified();
        }

        // Handle newsletter subscription
        if ($this->subscribeToNewsletter && $this->email && $this->name) {
            $subscription = NewsletterSubscription::updateOrCreate(
                ['email' => $this->email],
                [
                    'name' => $this->name,
                    'source' => 'book_review'
                ]
            );

            if (!$subscription->is_verified) {
                $newsletterToken = $subscription->generateVerificationToken();
                $this->sendNewsletterVerificationEmail($subscription, $newsletterToken);
            }
        }

        // Note: Admin notification is sent automatically via BookReviewObserver

        session()->flash('success', $this->email
            ? 'Thank you for your review! Please check your email to verify your submission.'
            : 'Thank you for your review! It will be published after admin approval.');

        $this->reset(['rating', 'reviewText', 'signature', 'email', 'name', 'subscribeToNewsletter', 'showNewsletterFields']);
        
        $this->dispatch('reviewSubmitted');
    }

    private function sendVerificationEmail(BookReview $review, string $token)
    {
        $verificationUrl = route('review.verify', ['token' => $token]);
        
        Mail::raw(
            "Please verify your book review by clicking this link: {$verificationUrl}\n\n" .
            "Book: {$this->book->title}\n" .
            "Rating: {$review->butterfly_rating}\n" .
            ($review->review_text ? "Review: {$review->review_text}\n" : '') .
            "\nThank you for sharing your thoughts!",
            function ($mail) use ($review) {
                $mail->to($review->reviewer_email)
                    ->subject("Verify Your Review for '{$this->book->title}'");
            }
        );
    }

    private function sendNewsletterVerificationEmail(NewsletterSubscription $subscription, string $token)
    {
        $verificationUrl = route('newsletter.verify', ['token' => $token]);
        
        Mail::raw(
            "Welcome to Linda's Creative Newsletter!\n\n" .
            "Please verify your subscription by clicking this link: {$verificationUrl}\n\n" .
            "You'll receive updates about new books, art pieces, and creative inspiration.\n\n" .
            "Thank you for joining our creative community!",
            function ($mail) use ($subscription) {
                $mail->to($subscription->email)
                    ->subject("Verify Your Newsletter Subscription - Linda's Creative Newsletter");
            }
        );
    }

    public function render()
    {
        return view('livewire.book-review-form');
    }
}
