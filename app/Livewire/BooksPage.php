<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Language;
use Livewire\Component;

class BooksPage extends Component
{
    public ?int $selectedLanguageId = null;

    public function render()
    {
        $languages = Language::where('is_active', true)->get();

        $booksQuery = Book::where('is_published', true)
            ->with(['purchaseLinks.language'])
            ->orderBy('sort_order');

        if ($this->selectedLanguageId) {
            $booksQuery->whereHas('purchaseLinks', function ($query) {
                $query->where('language_id', $this->selectedLanguageId);
            });
        }

        $books = $booksQuery->get();

        $seoData = [
            'title' => 'Books | By Ek Publishing - Linda Ettehag Kviby',
            'description' => 'Explore emotional journeys through powerful storytelling. Discover psychological thriller books by Swedish author Linda Ettehag Kviby, available in multiple languages.',
            'keywords' => 'Linda Ettehag Kviby books, Swedish author, psychological thriller, emotional storytelling, multilingual books, Swedish literature',
            'image' => asset('images/default-og-image.jpg'),
            'url' => route('books'),
            'type' => 'website',
            'author' => 'Linda Ettehag Kviby',
            'site_name' => 'By Ek Publishing',
        ];

        return view('livewire.books-page', [
            'books' => $books,
            'languages' => $languages,
            'seoData' => $seoData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
