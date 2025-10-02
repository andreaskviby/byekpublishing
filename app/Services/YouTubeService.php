<?php

namespace App\Services;

use App\Models\YouTubeVideo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YouTubeService
{
    private ?string $apiKey;
    private ?string $channelId;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
        $this->channelId = config('services.youtube.channel_id');
    }

    public function syncVideos(): int
    {
        if (! $this->apiKey || ! $this->channelId) {
            Log::warning('YouTube API credentials not configured. Add YOUTUBE_API_KEY and YOUTUBE_CHANNEL_ID to your .env file.');
            return 0;
        }

        try {
            $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
                'key' => $this->apiKey,
                'channelId' => $this->channelId,
                'part' => 'snippet',
                'order' => 'date',
                'maxResults' => 50,
                'type' => 'video',
            ]);

            if (! $response->successful()) {
                Log::error('YouTube API request failed', ['status' => $response->status()]);
                return 0;
            }

            $data = $response->json();
            $count = 0;

            foreach ($data['items'] ?? [] as $item) {
                $this->storeVideo($item);
                $count++;
            }

            Log::info("Synced {$count} videos from YouTube");
            return $count;
        } catch (\Exception $e) {
            Log::error('YouTube sync failed', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    private function storeVideo(array $item): void
    {
        $videoId = $item['id']['videoId'] ?? null;

        if (! $videoId) {
            return;
        }

        YouTubeVideo::updateOrCreate(
            ['youtube_id' => $videoId],
            [
                'title' => $item['snippet']['title'] ?? '',
                'description' => $item['snippet']['description'] ?? '',
                'thumbnail_url' => $item['snippet']['thumbnails']['high']['url'] ?? null,
                'published_at' => $item['snippet']['publishedAt'] ?? now(),
            ]
        );
    }
}
