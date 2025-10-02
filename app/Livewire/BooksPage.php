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

        return view('livewire.books-page', [
            'books' => $books,
            'languages' => $languages,
        ])->layout('layouts.app')->title('Books');
    }
}
