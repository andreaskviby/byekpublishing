<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscription extends Model
{
    protected $fillable = [
        'name',
        'email',
        'is_verified',
        'verification_token',
        'verified_at',
        'ip_address',
        'user_agent',
        'source'
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
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

    // Scope for verified subscriptions
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ip_address = request()->ip();
            $model->user_agent = request()->userAgent();
        });
    }
}
