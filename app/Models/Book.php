<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_description',
        'meta_keywords',
        'cover_image',
        'isbn',
        'publication_date',
        'pages',
        'genre',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'publication_date' => 'date',
            'is_published' => 'boolean',
            'pages' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function purchaseLinks(): HasMany
    {
        return $this->hasMany(PurchaseLink::class);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }

        // If path starts with /images/ or /storage/, return as is
        if (str_starts_with($this->cover_image, '/images/') || str_starts_with($this->cover_image, '/storage/')) {
            return $this->cover_image;
        }

        // Otherwise, prepend /storage/ for files uploaded via Filament
        return '/storage/' . $this->cover_image;
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
