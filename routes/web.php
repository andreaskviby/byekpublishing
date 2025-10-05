<?php

use App\Http\Controllers\SpotifyOAuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\YouTubeOAuthController;
use App\Livewire\ArtGallery;
use App\Livewire\ArtPieceDetail;
use App\Livewire\AuthorPage;
use App\Livewire\BlogPostDetail;
use App\Livewire\BookDetail;
use App\Livewire\BooksPage;
use App\Livewire\ContactForm;
use App\Livewire\HomePage;
use App\Livewire\MusicPage;
use App\Livewire\MusicReleaseDetail;
use App\Livewire\VideoDetail;
use App\Livewire\VideosPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/author', AuthorPage::class)->name('author');
Route::get('/books', BooksPage::class)->name('books');
Route::get('/books/{book:slug}', BookDetail::class)->name('book.detail');
Route::get('/art', ArtGallery::class)->name('art');
Route::get('/art/{artPiece:slug}', ArtPieceDetail::class)->name('art.detail');
Route::get('/music', MusicPage::class)->name('music');
Route::get('/music/{musicRelease:slug}', MusicReleaseDetail::class)->name('music.detail');
Route::get('/videos', VideosPage::class)->name('videos');
Route::get('/videos/{youTubeVideo:slug}', VideoDetail::class)->name('video.detail');
Route::get('/blog/{blogPost:slug}', BlogPostDetail::class)->name('blog.detail');
Route::get('/contact', ContactForm::class)->name('contact');

// Verification routes
Route::get('/verify/review/{token}', [VerificationController::class, 'verifyReview'])->name('review.verify');
Route::get('/verify/newsletter/{token}', [VerificationController::class, 'verifyNewsletter'])->name('newsletter.verify');

// YouTube OAuth routes
Route::get('/youtube/oauth/authorize', [YouTubeOAuthController::class, 'authorize'])->name('youtube.oauth.authorize');
Route::get('/youtube/oauth/callback', [YouTubeOAuthController::class, 'callback'])->name('youtube.oauth.callback');

// Spotify OAuth routes
Route::get('/spotify/authorize', [SpotifyOAuthController::class, 'authorize'])->name('spotify.oauth.authorize');
Route::get('/spotify/callback', [SpotifyOAuthController::class, 'callback'])->name('spotify.oauth.callback');

// Sitemap
Route::get('/sitemap.xml', function () {
    return response(view('sitemap'), 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

// Dynamic robots.txt
Route::get('/robots.txt', function () {
    return response(view('robots'), 200, ['Content-Type' => 'text/plain']);
})->name('robots');
