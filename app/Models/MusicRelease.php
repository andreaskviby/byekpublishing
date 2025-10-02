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

    public function getAlbumCoverUrlAttribute(): ?string
    {
        if (!$this->album_cover) {
            return null;
        }

        // If path already starts with /storage/, return as is
        if (str_starts_with($this->album_cover, '/storage/')) {
            return $this->album_cover;
        }

        // Otherwise, prepend /storage/ for files uploaded via Filament
        return '/storage/' . $this->album_cover;
    }
}
