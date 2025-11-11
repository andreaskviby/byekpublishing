<?php

namespace App\Observers;

use App\Models\BookReview;
use Illuminate\Support\Facades\Mail;

class BookReviewObserver
{
    /**
     * Handle the BookReview "created" event.
     */
    public function created(BookReview $bookReview): void
    {
        // Send admin notification email
        $this->sendAdminNotification($bookReview);
    }

    /**
     * Send notification to admin about new book review
     */
    private function sendAdminNotification(BookReview $bookReview): void
    {
        try {
            $book = $bookReview->book;

            Mail::raw(
                "New book review submitted:\n\n" .
                "Book: {$book->title}\n" .
                "Rating: {$bookReview->butterfly_rating}\n" .
                "Signature: " . ($bookReview->reviewer_signature ?: 'Anonymous') . "\n" .
                "Email: " . ($bookReview->reviewer_email ?: 'Not provided') . "\n" .
                ($bookReview->review_text ? "Review: {$bookReview->review_text}\n" : '') .
                "Newsletter signup: " . ($bookReview->subscribed_to_newsletter ? 'Yes' : 'No') . "\n" .
                "Verified: " . ($bookReview->is_verified ? 'Yes' : 'No') . "\n" .
                "Approved: " . ($bookReview->is_approved ? 'Yes' : 'No') . "\n\n" .
                "View in admin panel: " . url('/admin/book-reviews'),
                function ($mail) {
                    $mail->to('linda.ettehag@gmail.com')
                        ->subject("New Book Review Awaiting Approval");
                }
            );
        } catch (\Exception $e) {
            // Log error but don't fail the review creation
            \Log::error('Failed to send book review notification email: ' . $e->getMessage());
        }
    }

    /**
     * Handle the BookReview "updated" event.
     */
    public function updated(BookReview $bookReview): void
    {
        //
    }

    /**
     * Handle the BookReview "deleted" event.
     */
    public function deleted(BookReview $bookReview): void
    {
        //
    }

    /**
     * Handle the BookReview "restored" event.
     */
    public function restored(BookReview $bookReview): void
    {
        //
    }

    /**
     * Handle the BookReview "force deleted" event.
     */
    public function forceDeleted(BookReview $bookReview): void
    {
        //
    }
}
