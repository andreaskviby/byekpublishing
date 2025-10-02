<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YouTubeVideo extends Model
{
    protected $fillable = [
        'youtube_id',
        'title',
        'description',
        'thumbnail_url',
        'published_at',
        'duration',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'view_count' => 'integer',
        ];
    }
}
