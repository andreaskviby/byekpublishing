<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Language;
use App\Models\PurchaseLink;
use Illuminate\Database\Seeder;

class PurchaseLinkSeeder extends Seeder
{
    public function run(): void
    {
        $englishBook = Book::where('title', 'Shadow of a Butterfly')->first();
        $swedishBook = Book::where('title', 'Fjärilsskugga')->first();
        $italianBook = Book::where('title', 'Ombra di Farfalla')->first();

        $english = Language::where('code', 'en')->first();
        $swedish = Language::where('code', 'sv')->first();
        $italian = Language::where('code', 'it')->first();

        // English book purchase links
        PurchaseLink::create([
            'book_id' => $englishBook->id,
            'language_id' => $english->id,
            'store_name' => 'Everand',
            'url' => 'https://www.everand.com/book/758737504/Shadow-of-a-Butterfly?utm_source=byek&utm_medium=website&utm_campaign=book_purchase',
            'price' => null,
            'currency' => null,
            'format' => 'eBook',
            'is_active' => true,
        ]);

        // Swedish book purchase links
        PurchaseLink::create([
            'book_id' => $swedishBook->id,
            'language_id' => $swedish->id,
            'store_name' => 'Akademibokhandeln',
            'url' => 'https://www.akademibokhandeln.se/bok/fjarilsskugga/9789198965810?utm_source=byek&utm_medium=website&utm_campaign=book_purchase',
            'price' => null,
            'currency' => null,
            'format' => 'eBook',
            'is_active' => true,
        ]);

        PurchaseLink::create([
            'book_id' => $swedishBook->id,
            'language_id' => $swedish->id,
            'store_name' => 'Storytel',
            'url' => 'https://www.storytel.com?utm_source=byek&utm_medium=website&utm_campaign=book_purchase',
            'price' => null,
            'currency' => null,
            'format' => 'Audiobook',
            'is_active' => true,
        ]);

        // Italian book purchase links
        PurchaseLink::create([
            'book_id' => $italianBook->id,
            'language_id' => $italian->id,
            'store_name' => 'IBS.it',
            'url' => 'https://www.ibs.it/ombra-di-farfalla-ebook-linda-ettehag-kviby/e/9789198965834?utm_source=byek&utm_medium=website&utm_campaign=book_purchase',
            'price' => null,
            'currency' => null,
            'format' => 'eBook',
            'is_active' => true,
        ]);

        PurchaseLink::create([
            'book_id' => $italianBook->id,
            'language_id' => $italian->id,
            'store_name' => 'Google Books',
            'url' => 'https://books.google.com?utm_source=byek&utm_medium=website&utm_campaign=book_purchase',
            'price' => null,
            'currency' => null,
            'format' => 'eBook',
            'is_active' => true,
        ]);
    }
}
