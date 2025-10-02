<?php

use App\Livewire\ArtGallery;
use App\Livewire\AuthorPage;
use App\Livewire\BooksPage;
use App\Livewire\ContactForm;
use App\Livewire\HomePage;
use App\Livewire\MusicPage;
use App\Livewire\VideosPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/author', AuthorPage::class)->name('author');
Route::get('/books', BooksPage::class)->name('books');
Route::get('/art', ArtGallery::class)->name('art');
Route::get('/music', MusicPage::class)->name('music');
Route::get('/videos', VideosPage::class)->name('videos');
Route::get('/contact', ContactForm::class)->name('contact');
