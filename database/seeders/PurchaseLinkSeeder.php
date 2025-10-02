<?php

namespace Database\Seeders;

use App\Helpers\UrlHelper;
use App\Models\Book;
use App\Models\Language;
use App\Models\PurchaseLink;
use Illuminate\Database\Seeder;

class PurchaseLinkSeeder extends Seeder
{
    public function run(): void
    {
        $book = Book::where('isbn', '9789198965810')->first();

        if (! $book) {
            return;
        }

        $english = Language::where('code', 'en')->first();
        $swedish = Language::where('code', 'sv')->first();
        $italian = Language::where('code', 'it')->first();

        if ($english) {
            PurchaseLink::updateOrCreate(
                [
                    'book_id' => $book->id,
                    'language_id' => $english->id,
                    'store_name' => 'Everand',
                ],
                [
                    'url' => UrlHelper::addUtmParameters('https://www.everand.com/book/758737504/Shadow-of-a-Butterfly'),
                    'format' => 'eBook',
                    'is_active' => true,
                ]
            );
        }

        if ($swedish) {
            PurchaseLink::updateOrCreate(
                [
                    'book_id' => $book->id,
                    'language_id' => $swedish->id,
                    'store_name' => 'Akademibokhandeln',
                ],
                [
                    'url' => UrlHelper::addUtmParameters('https://www.akademibokhandeln.se/bok/fjarilsskugga/9789198965810'),
                    'format' => 'eBook',
                    'is_active' => true,
                ]
            );

            PurchaseLink::updateOrCreate(
                [
                    'book_id' => $book->id,
                    'language_id' => $swedish->id,
                    'store_name' => 'Storytel',
                ],
                [
                    'url' => UrlHelper::addUtmParameters('https://www.storytel.com'),
                    'format' => 'Audiobook',
                    'is_active' => true,
                ]
            );
        }

        if ($italian) {
            PurchaseLink::updateOrCreate(
                [
                    'book_id' => $book->id,
                    'language_id' => $italian->id,
                    'store_name' => 'IBS.it',
                ],
                [
                    'url' => UrlHelper::addUtmParameters('https://www.ibs.it/ombra-di-farfalla-ebook-linda-ettehag-kviby/e/9789198965834'),
                    'format' => 'eBook',
                    'is_active' => true,
                ]
            );

            PurchaseLink::updateOrCreate(
                [
                    'book_id' => $book->id,
                    'language_id' => $italian->id,
                    'store_name' => 'Google Books',
                ],
                [
                    'url' => UrlHelper::addUtmParameters('https://books.google.com'),
                    'format' => 'eBook',
                    'is_active' => true,
                ]
            );
        }
    }
}
