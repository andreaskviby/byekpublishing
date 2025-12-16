<?php

namespace App\Livewire;

use App\Models\Book;
use App\Services\SeoService;
use Livewire\Component;

class BookOrderDetail extends Component
{
    public Book $book;

    public function mount(Book $book): void
    {
        abort_unless($book->isAvailable() && $book->allow_christmas_orders, 404);
        $this->book = $book;
    }

    public function render()
    {
        $seoTitle = "Bestall {$this->book->title} med julklappsinpackning";

        $seoDescription = "Bestall {$this->book->title} som perfekt julklapp! Signerad, inpackad och hemskickad. Endast {$this->book->price} SEK (+49 SEK for julinslagning).";

        $seoData = SeoService::generateMetaTags(
            $this->book,
            $seoTitle,
            $seoDescription
        );

        $structuredData = SeoService::generateStructuredData($this->book);

        return view('livewire.book-order-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
