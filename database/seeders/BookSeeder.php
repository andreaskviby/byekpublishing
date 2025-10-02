<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::updateOrCreate(
            ['isbn' => '9789198965810'],
            [
                'title' => 'Shadow of a Butterfly',
                'description' => 'A powerful story exploring themes of transformation, resilience, and the delicate beauty of human connections.',
                'cover_image' => null,
                'isbn' => '9789198965810',
                'publication_date' => '2023-01-01',
                'pages' => 250,
                'genre' => 'Fiction',
                'is_published' => true,
                'sort_order' => 1,
            ]
        );
    }
}
