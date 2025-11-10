<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'street_address',
        'max_attendees',
        'is_active',
        'hero_banner_image',
        'hero_graphic_image',
        'hero_subtitle',
        'hero_badge_text',
        'hero_call_to_action',
        'page_color',
        'hero_text_color',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function rsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function availableSpots(): int
    {
        return $this->max_attendees - $this->rsvps()->sum('number_of_guests');
    }

    public function isFull(): bool
    {
        return $this->availableSpots() <= 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
