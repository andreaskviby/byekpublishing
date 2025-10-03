<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BookReview extends Model
{
    protected $fillable = [
        'book_id',
        'language_id',
        'rating',
        'review_text',
        'reviewer_signature',
        'reviewer_email',
        'subscribed_to_newsletter',
        'is_approved',
        'is_verified',
        'verification_token',
        'verified_at',
        'ip_address',
        'user_agent',
        'submitted_at'
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_verified' => 'boolean',
            'subscribed_to_newsletter' => 'boolean',
            'verified_at' => 'datetime',
            'submitted_at' => 'datetime',
            'rating' => 'integer',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function generateVerificationToken(): string
    {
        $this->verification_token = Str::random(60);
        $this->save();
        
        return $this->verification_token;
    }

    public function markAsVerified(): void
    {
        $this->is_verified = true;
        $this->verified_at = now();
        $this->verification_token = null;
        $this->save();
    }

    // Scope for approved reviews
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope for verified reviews
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Get butterfly rating display
    public function getButterflyRatingAttribute(): string
    {
        return str_repeat('🦋', $this->rating) . str_repeat('🤍', 5 - $this->rating);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->submitted_at = now();
            $model->ip_address = request()->ip();
            $model->user_agent = request()->userAgent();
        });
    }
}
