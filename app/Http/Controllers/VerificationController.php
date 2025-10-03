<?php

namespace App\Http\Controllers;

use App\Models\BookReview;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyReview($token)
    {
        $review = BookReview::where('verification_token', $token)
            ->where('is_verified', false)
            ->first();

        if (!$review) {
            return view('verification.invalid')->with([
                'title' => 'Invalid Review Verification Link',
                'message' => 'This verification link is invalid or has already been used.'
            ]);
        }

        $review->markAsVerified();

        return view('verification.success')->with([
            'title' => 'Review Verified Successfully!',
            'message' => 'Thank you for verifying your review. It will be published after admin approval.',
            'type' => 'review'
        ]);
    }

    public function verifyNewsletter($token)
    {
        $subscription = NewsletterSubscription::where('verification_token', $token)
            ->where('is_verified', false)
            ->first();

        if (!$subscription) {
            return view('verification.invalid')->with([
                'title' => 'Invalid Newsletter Verification Link',
                'message' => 'This verification link is invalid or has already been used.'
            ]);
        }

        $subscription->markAsVerified();

        return view('verification.success')->with([
            'title' => 'Newsletter Subscription Verified!',
            'message' => "Welcome to Linda's Creative Newsletter! You'll now receive updates about new books, art pieces, and creative inspiration.",
            'type' => 'newsletter'
        ]);
    }
}
