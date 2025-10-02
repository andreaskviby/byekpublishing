<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramPost extends Model
{
    protected $fillable = [
        'instagram_id',
        'caption',
        'media_type',
        'media_url',
        'permalink',
        'published_at',
        'like_count',
        'comments_count',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'like_count' => 'integer',
            'comments_count' => 'integer',
        ];
    }
}
