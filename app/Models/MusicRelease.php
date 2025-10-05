<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MusicRelease extends Model
{
    protected $fillable = [
        'spotify_id',
        'title',
        'slug',
        'artist_name',
        'meta_description',
        'meta_keywords',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
