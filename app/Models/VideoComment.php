<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoComment extends Model
{
    protected $fillable = [
        'you_tube_video_id',
        'comment_id',
        'author_name',
        'author_channel_id',
        'comment_text',
        'like_count',
        'published_at',
        'is_approved',
        'has_ai_reply',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_approved' => 'boolean',
            'has_ai_reply' => 'boolean',
            'like_count' => 'integer',
        ];
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(YouTubeVideo::class, 'you_tube_video_id');
    }
}
