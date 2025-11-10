<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRsvp extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'number_of_guests',
        'ip_address',
        'user_agent',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
