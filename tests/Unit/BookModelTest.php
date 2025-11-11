<?php

namespace Tests\Unit;

use App\Models\Book;
use Tests\TestCase;

class BookModelTest extends TestCase
{
    /**
     * Test that Book model uses slug as route key.
     */
    public function test_book_model_uses_slug_as_route_key(): void
    {
        $book = new Book;

        $this->assertEquals('slug', $book->getRouteKeyName());
    }
}
