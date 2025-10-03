<?php

namespace App\Livewire;

use App\Models\Book;
use App\Services\SeoService;
use Livewire\Component;

class BookDetail extends Component
{
    public Book $book;

    public function mount(Book $book)
    {
        if (!$book->is_published) {
            abort(404);
        }
        
        $this->book = $book;
    }

    public function render()
    {
        $seoData = SeoService::generateMetaTags($this->book);
        $structuredData = SeoService::generateStructuredData($this->book);

        return view('livewire.book-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')
          ->title($seoData['title']);
    }
}
