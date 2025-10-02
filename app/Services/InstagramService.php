<?php

namespace App\Services;

use App\Models\InstagramPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    private ?string $accessToken;
    private ?string $userId;

    public function __construct()
    {
        $this->accessToken = config('services.instagram.access_token');
        $this->userId = config('services.instagram.user_id');
    }

    public function syncPosts(): int
    {
        if (! $this->accessToken || ! $this->userId) {
            Log::warning('Instagram API credentials not configured. Add INSTAGRAM_ACCESS_TOKEN and INSTAGRAM_USER_ID to your .env file.');
            return 0;
        }

        try {
            $response = Http::get("https://graph.instagram.com/{$this->userId}/media", [
                'fields' => 'id,caption,media_type,media_url,permalink,timestamp,like_count,comments_count',
                'access_token' => $this->accessToken,
                'limit' => 50,
            ]);

            if (! $response->successful()) {
                Log::error('Instagram API request failed', ['status' => $response->status()]);
                return 0;
            }

            $data = $response->json();
            $count = 0;

            foreach ($data['data'] ?? [] as $item) {
                $this->storePost($item);
                $count++;
            }

            Log::info("Synced {$count} posts from Instagram");
            return $count;
        } catch (\Exception $e) {
            Log::error('Instagram sync failed', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    private function storePost(array $item): void
    {
        $postId = $item['id'] ?? null;

        if (! $postId) {
            return;
        }

        InstagramPost::updateOrCreate(
            ['instagram_id' => $postId],
            [
                'caption' => $item['caption'] ?? '',
                'media_type' => $item['media_type'] ?? 'IMAGE',
                'media_url' => $item['media_url'] ?? '',
                'permalink' => $item['permalink'] ?? '',
                'published_at' => $item['timestamp'] ?? now(),
                'like_count' => $item['like_count'] ?? 0,
                'comments_count' => $item['comments_count'] ?? 0,
            ]
        );
    }
}
