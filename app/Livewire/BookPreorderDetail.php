<?php

namespace App\Livewire;

use App\Models\Book;
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
        return view('livewire.book-preorder-detail')->layout('layouts.app')->title("Förbeställ {$this->book->title}");
    }
}
