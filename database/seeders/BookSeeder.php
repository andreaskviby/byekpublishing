<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Shadow of a Butterfly',
            'description' => 'A gripping psychological thriller exploring themes of loss, betrayal, and the fear of being deceived. The story unfolds in a picturesque small town on the Swedish West Coast.',
            'cover_image' => '/images/books/shadow-of-a-butterfly-en.jpg',
            'isbn' => null,
            'publication_date' => null,
            'pages' => 280,
            'genre' => 'Psychological Thriller',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Book::create([
            'title' => 'Fjärilsskugga',
            'description' => 'En gripande psykologisk thriller som utforskar teman om förlust, förräderi och rädslan för att bli bedragen. Berättelsen utspelar sig i en pittoresk liten stad på svenska västkusten.',
            'cover_image' => '/images/books/shadow-of-a-butterfly-sv.jpg',
            'isbn' => '9789198965810',
            'publication_date' => '2023-01-01',
            'pages' => 280,
            'genre' => 'Psychological Thriller',
            'is_published' => true,
            'sort_order' => 2,
        ]);

        Book::create([
            'title' => 'Ombra di Farfalla',
            'description' => 'Un avvincente thriller psicologico che esplora temi di perdita, tradimento e la paura di essere ingannati. La storia si svolge in una pittoresca cittadina sulla costa occidentale svedese.',
            'cover_image' => '/images/books/shadow-of-a-butterfly-it.jpg',
            'isbn' => null,
            'publication_date' => null,
            'pages' => 280,
            'genre' => 'Psychological Thriller',
            'is_published' => true,
            'sort_order' => 3,
        ]);
    }
}
