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
            'image' => $books->first()?->cover_image_url ?? asset('images/default-og-image.jpg'),
            'url' => route('books'),
            'type' => 'website',
            'author' => 'Linda Ettehag Kviby',
            'site_name' => 'By Ek Publishing',
            'twitter:card' => 'summary_large_image',
            'twitter:site' => '@lindaettehagkviby',
            'twitter:creator' => '@lindaettehagkviby',
            'og:image:width' => '1200',
            'og:image:height' => '630',
            'og:locale' => 'sv_SE',
        ];

        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Books by Linda Ettehag Kviby',
            'description' => 'Collection of books by Swedish author Linda Ettehag Kviby',
            'numberOfItems' => $books->count(),
            'itemListElement' => $books->filter(fn ($book) => ! empty($book->slug))->map(function ($book, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => [
                        '@type' => 'Book',
                        '@id' => route('book.detail', $book),
                        'name' => $book->title,
                        'description' => $book->meta_description ?? $book->description,
                        'image' => $book->cover_image_url,
                        'author' => [
                            '@type' => 'Person',
                            'name' => 'Linda Ettehag Kviby',
                            'url' => route('author'),
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => 'By Ek Publishing',
                            'url' => route('home'),
                        ],
                        'isbn' => $book->isbn,
                        'genre' => $book->genre,
                        'numberOfPages' => $book->pages,
                        'datePublished' => $book->publication_date?->format('Y-m-d'),
                        'inLanguage' => 'sv-SE',
                        'bookFormat' => 'https://schema.org/Paperback',
                    ],
                ];
            })->values()->all(),
        ];

        return view('livewire.books-page', [
            'books' => $books,
            'languages' => $languages,
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
