<?php

namespace App\Livewire;

use App\Models\ArtPiece;
use App\Models\BlogPost;
use App\Models\Book;
use App\Models\Event;
use App\Models\InstagramPost;
use App\Models\MusicRelease;
use App\Models\YouTubeVideo;
use App\Services\SeoService;
use App\Services\YouTubeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class HomePage extends Component
{
    public $youtubeSubscribers = 0;
    public $displaySubscribers = 1000;
    public $instagramFollowers = 0;
    public $targetSubscribers = 0;
    public $isAnimating = true;

    public function mount()
    {
        $this->loadSocialStats();
    }

    private function loadSocialStats()
    {
        $youtubeService = new YouTubeService();
        
        // Get real subscriber count
        $this->youtubeSubscribers = $youtubeService->getCachedSubscriberCount() ?? 0;
        $this->targetSubscribers = $this->youtubeSubscribers;

        $this->instagramFollowers = cache()->remember('instagram_followers', 3600, function () {
            return $this->getInstagramFollowers();
        });
    }

    public function updateSubscriberCount()
    {
        $youtubeService = new YouTubeService();
        $newCount = $youtubeService->getSubscriberCount();
        
        if ($newCount !== null && $newCount > $this->targetSubscribers) {
            $this->targetSubscribers = $newCount;
            $this->youtubeSubscribers = $newCount;
        }
    }

    public function incrementCounter()
    {
        if ($this->displaySubscribers < $this->targetSubscribers) {
            $increment = rand(3, 7);
            $this->displaySubscribers = min($this->displaySubscribers + $increment, $this->targetSubscribers);
            
            // If we reach the target, refresh the target from API
            if ($this->displaySubscribers >= $this->targetSubscribers) {
                $this->updateSubscriberCount();
            }
        }
    }

    private function getYoutubeSubscribers(): int
    {
        try {
            // Get latest video to extract channel info
            $latestVideo = YouTubeVideo::latest()->first();
            if (!$latestVideo || !$latestVideo->video_id) {
                return 0;
            }

            // Extract channel ID from video ID using YouTube API
            $apiKey = config('services.youtube.api_key');
            if (!$apiKey) {
                return 0;
            }

            $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
                'part' => 'snippet',
                'id' => $latestVideo->video_id,
                'key' => $apiKey,
            ]);

            if (!$response->successful()) {
                return 0;
            }

            $videoData = $response->json();
            if (empty($videoData['items'])) {
                return 0;
            }

            $channelId = $videoData['items'][0]['snippet']['channelId'];

            // Get channel statistics
            $channelResponse = Http::get("https://www.googleapis.com/youtube/v3/channels", [
                'part' => 'statistics',
                'id' => $channelId,
                'key' => $apiKey,
            ]);

            if (!$channelResponse->successful()) {
                return 0;
            }

            $channelData = $channelResponse->json();
            if (empty($channelData['items'])) {
                return 0;
            }

            return (int) ($channelData['items'][0]['statistics']['subscriberCount'] ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getInstagramFollowers(): int
    {
        try {
            // Get latest Instagram post to extract user info
            $latestPost = InstagramPost::latest()->first();
            if (!$latestPost || !$latestPost->permalink) {
                return 0;
            }

            // Extract username from permalink
            $username = $this->extractInstagramUsername($latestPost->permalink);
            if (!$username) {
                return 0;
            }

            // Note: Instagram Basic Display API would be needed for real-time data
            // For now, we'll return a placeholder or use a cached value
            // In production, you'd implement Instagram Basic Display API
            return cache()->remember("instagram_followers_{$username}", 3600, function () use ($username) {
                // Placeholder - implement Instagram API integration here
                return 0;
            });
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function extractInstagramUsername(string $permalink): ?string
    {
        if (preg_match('/instagram\.com\/([^\/]+)/', $permalink, $matches)) {
            return $matches[1];
        }
        return null;
    }
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

        $upcomingEvents = Event::where('is_active', true)
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date', 'asc')
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
            'upcomingEvents' => $upcomingEvents,
            'seoData' => $seoData,
            'organizationSchema' => $organizationSchema,
            'youtubeSubscribers' => $this->youtubeSubscribers,
            'instagramFollowers' => $this->instagramFollowers,
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
