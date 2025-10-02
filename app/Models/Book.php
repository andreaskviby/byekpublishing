<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
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
}
