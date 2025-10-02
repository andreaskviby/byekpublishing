<?php

namespace App\Livewire;

use App\Models\ArtPiece;
use App\Models\BlogPost;
use App\Models\Book;
use App\Models\InstagramPost;
use App\Models\MusicRelease;
use App\Models\YouTubeVideo;
use App\Services\SeoService;
use Illuminate\Support\Collection;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $featuredBook = Book::where('is_published', true)
            ->orderBy('sort_order')
            ->first();

        $activityFeed = $this->getActivityFeed();

        $artPieces = ArtPiece::where('is_available', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $musicReleases = MusicRelease::where('is_published', true)
            ->orderBy('release_date', 'desc')
            ->limit(3)
            ->get();

        // Generate SEO data for home page
        $seoData = [
            'title' => 'By Ek Publishing | Linda Ettehag Kviby - Books, Art & Music',
            'description' => 'Discover creative works by Linda Ettehag Kviby at By Ek Publishing. Explore psychological thriller books, art pieces, music releases, and videos from Swedish author and artist.',
            'keywords' => 'Linda Ettehag Kviby, By Ek Publishing, Swedish author, psychological thriller, books, art, music, creative works, Swedish literature',
            'image' => asset('images/default-og-image.jpg'),
            'url' => route('home'),
            'type' => 'website',
            'author' => 'Linda Ettehag Kviby',
            'site_name' => 'By Ek Publishing',
        ];

        $organizationSchema = SeoService::generateOrganizationSchema();

        return view('livewire.home-page', [
            'featuredBook' => $featuredBook,
            'activityFeed' => $activityFeed,
            'artPieces' => $artPieces,
            'musicReleases' => $musicReleases,
            'seoData' => $seoData,
            'organizationSchema' => $organizationSchema,
        ])->layout('layouts.app');
    }

    private function getActivityFeed(): Collection
    {
        $blogPosts = BlogPost::where('is_published', true)
            ->with('user')
            ->get()
            ->map(fn ($post) => [
                'type' => 'blog',
                'data' => $post,
                'date' => $post->published_at,
            ]);

        $youtubeVideos = YouTubeVideo::all()
            ->map(fn ($video) => [
                'type' => 'youtube',
                'data' => $video,
                'date' => $video->published_at,
            ]);

        $instagramPosts = InstagramPost::all()
            ->map(fn ($post) => [
                'type' => 'instagram',
                'data' => $post,
                'date' => $post->published_at,
            ]);

        return collect()
            ->merge($blogPosts)
            ->merge($youtubeVideos)
            ->merge($instagramPosts)
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }
}
