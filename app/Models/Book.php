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
        'sample_pdf',
        'isbn',
        'price',
        'publication_date',
        'pages',
        'genre',
        'is_published',
        'status',
        'allow_christmas_orders',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'publication_date' => 'date',
            'is_published' => 'boolean',
            'allow_christmas_orders' => 'boolean',
            'pages' => 'integer',
            'price' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function purchaseLinks(): HasMany
    {
        return $this->hasMany(PurchaseLink::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BookReview::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(BookReview::class)->approved()->verified();
    }

    public function preorders(): HasMany
    {
        return $this->hasMany(BookPreorder::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // For Filament admin, use ID; for frontend, use slug
        if (request()->is('admin/*') || request()->is('filament/*')) {
            return $this->where('id', $value)->firstOrFail();
        }
        
        return $this->where('slug', $value)->firstOrFail();
    }

    public function isSoonToBeReleased(): bool
    {
        return $this->status === 'soon_to_be_released';
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        // If path starts with /images/ or /storage/, return as is
        if (str_starts_with($this->cover_image, '/images/') || str_starts_with($this->cover_image, '/storage/')) {
            return $this->cover_image;
        }

        // Otherwise, prepend /storage/ for files uploaded via Filament
        return '/storage/'.$this->cover_image;
    }

    public function getSamplePdfUrlAttribute(): ?string
    {
        if (! $this->sample_pdf) {
            return null;
        }

        // If path starts with /storage/, return as is
        if (str_starts_with($this->sample_pdf, '/storage/')) {
            return $this->sample_pdf;
        }

        // Otherwise, prepend /storage/ for files uploaded via Filament
        return '/storage/'.$this->sample_pdf;
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
}
