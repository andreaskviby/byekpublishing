<?php

namespace App\Livewire;

use App\Models\Book;
use App\Services\SeoService;
use Livewire\Component;

class BookSignedOrderDetail extends Component
{
    public Book $book;

    public function mount(Book $book): void
    {
        abort_unless($book->isAvailable() && $book->allow_signed_orders, 404);
        $this->book = $book;
    }

    public function render()
    {
        $seoTitle = "Bestall {$this->book->title} med signering";

        $seoDescription = "Bestall {$this->book->title} signerad av forfattaren! Be om en personlig dedikation och fa boken hemskickad. Endast {$this->book->price} SEK inkl. frakt.";

        $seoData = SeoService::generateMetaTags(
            $this->book,
            $seoTitle,
            $seoDescription
        );

        $structuredData = SeoService::generateStructuredData($this->book);

        return view('livewire.book-signed-order-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
