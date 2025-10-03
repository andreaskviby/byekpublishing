<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class YouTubeVideo extends Model
{
    protected $fillable = [
        'youtube_id',
        'title',
        'slug',
        'description',
        'meta_description',
        'meta_keywords',
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

    public function comments(): HasMany
    {
        return $this->hasMany(VideoComment::class, 'you_tube_video_id');
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(VideoComment::class, 'you_tube_video_id')->where('is_approved', true)->orderBy('published_at', 'desc');
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
