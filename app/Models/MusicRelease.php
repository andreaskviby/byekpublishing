<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicRelease extends Model
{
    protected $fillable = [
        'title',
        'artist_name',
        'album_cover',
        'release_type',
        'release_date',
        'spotify_url',
        'apple_music_url',
        'youtube_music_url',
        'distrokid_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'is_published' => 'boolean',
        ];
    }
}
