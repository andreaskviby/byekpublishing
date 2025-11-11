<?php

namespace App\Providers;

use App\Models\BookPreorder;
use App\Models\BookReview;
use App\Observers\BookPreorderObserver;
use App\Observers\BookReviewObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BookPreorder::observe(BookPreorderObserver::class);
        BookReview::observe(BookReviewObserver::class);
    }
}
