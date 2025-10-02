<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtPiece extends Model
{
    protected $fillable = [
        'title',
        'description',
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
}
