<?php

namespace App\Livewire;

use App\Models\Book;
use App\Services\SeoService;
use Livewire\Component;

class BookPreorderDetail extends Component
{
    public Book $book;

    public function mount(Book $book): void
    {
        abort_unless($book->isSoonToBeReleased() || $book->allow_christmas_orders, 404);
        $this->book = $book;
    }

    public function render()
    {
        $seoTitle = $this->book->isSoonToBeReleased()
            ? "Förbeställ {$this->book->title}"
            : "Beställ {$this->book->title} med julklappsinpackning";

        $seoDescription = $this->book->isSoonToBeReleased()
            ? "Förbeställ {$this->book->title} av Linda Ettehag Kviby. Få boken hemskickad så fort den är tillgänglig. Signerad med dedikation."
            : "Beställ {$this->book->title} som perfekt julklapp! Signerad, inpackad och hemskickad. Endast {$this->book->price} SEK (+49 SEK för julinslagning).";

        $seoData = SeoService::generateMetaTags(
            $this->book,
            $seoTitle,
            $seoDescription
        );

        $structuredData = SeoService::generateStructuredData($this->book);

        return view('livewire.book-preorder-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
