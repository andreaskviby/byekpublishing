<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArtPiece extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_description',
        'meta_keywords',
        'image_path',
        'medium',
        'dimensions',
        'year',
        'is_available',
        'price',
        'currency',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_available' => 'boolean',
            'price' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        // If path already starts with /storage/, return as is
        if (str_starts_with($this->image_path, '/storage/')) {
            return $this->image_path;
        }

        // Otherwise, prepend /storage/ for files uploaded via Filament
        return '/storage/' . $this->image_path;
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
