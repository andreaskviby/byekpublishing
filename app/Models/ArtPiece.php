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
}
