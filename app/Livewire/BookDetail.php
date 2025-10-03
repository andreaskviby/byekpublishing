<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Language;
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

        // Get approved reviews grouped by language
        $reviewsByLanguage = $this->book->approvedReviews()
            ->with('language')
            ->orderBy('submitted_at', 'desc')
            ->get()
            ->groupBy('language.name');

        // Calculate average rating and statistics
        $approvedReviews = $this->book->approvedReviews;
        $averageRating = $approvedReviews->avg('rating');
        $totalReviews = $approvedReviews->count();
        $ratingCounts = $approvedReviews->countBy('rating');

        // Get available languages for reviews
        $languages = Language::all();

        return view('livewire.book-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
            'reviewsByLanguage' => $reviewsByLanguage,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'ratingCounts' => $ratingCounts,
            'languages' => $languages,
        ])->layout('layouts.app')
          ->title($seoData['title']);
    }
}
