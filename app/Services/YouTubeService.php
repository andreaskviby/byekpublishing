<?php

namespace App\Services;

use App\Models\VideoComment;
use App\Models\YouTubeVideo;
use Illuminate\Support\Facades\Cache;
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

    public function syncComments(): int
    {
        if (! $this->apiKey) {
            Log::warning('YouTube API key not configured.');
            return 0;
        }

        $videos = YouTubeVideo::all();
        $totalComments = 0;

        foreach ($videos as $video) {
            $commentCount = $this->syncCommentsForVideo($video);
            $totalComments += $commentCount;
        }

        Log::info("Synced {$totalComments} comments from YouTube");
        return $totalComments;
    }

    private function syncCommentsForVideo(YouTubeVideo $video): int
    {
        try {
            $response = Http::get('https://www.googleapis.com/youtube/v3/commentThreads', [
                'key' => $this->apiKey,
                'videoId' => $video->youtube_id,
                'part' => 'snippet',
                'maxResults' => 100,
                'order' => 'time',
            ]);

            if (! $response->successful()) {
                Log::error('YouTube comments API request failed', [
                    'video_id' => $video->youtube_id,
                    'status' => $response->status(),
                ]);
                return 0;
            }

            $data = $response->json();
            $count = 0;

            foreach ($data['items'] ?? [] as $item) {
                $this->storeComment($video, $item);
                $count++;
            }

            // Clear cache for this video's comments
            Cache::forget("video_comments_{$video->id}");

            return $count;
        } catch (\Exception $e) {
            Log::error('Comment sync failed for video', [
                'video_id' => $video->youtube_id,
                'error' => $e->getMessage(),
            ]);
            return 0;
        }
    }

    private function storeComment(YouTubeVideo $video, array $item): void
    {
        $topLevelComment = $item['snippet']['topLevelComment'] ?? null;

        if (! $topLevelComment) {
            return;
        }

        $commentId = $topLevelComment['id'] ?? null;
        $snippet = $topLevelComment['snippet'] ?? [];

        if (! $commentId) {
            return;
        }

        VideoComment::updateOrCreate(
            ['comment_id' => $commentId],
            [
                'you_tube_video_id' => $video->id,
                'author_name' => $snippet['authorDisplayName'] ?? 'Unknown',
                'author_channel_id' => $snippet['authorChannelId']['value'] ?? null,
                'comment_text' => $snippet['textDisplay'] ?? '',
                'like_count' => $snippet['likeCount'] ?? 0,
                'published_at' => $snippet['publishedAt'] ?? now(),
            ]
        );
    }

    public function replyToComment(VideoComment $comment, string $replyText): bool
    {
        $accessToken = $this->getValidAccessToken();

        if (! $accessToken) {
            Log::warning('YouTube OAuth not authorized. Run: php artisan youtube:authorize');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ])->post('https://www.googleapis.com/youtube/v3/comments', [
                'part' => 'snippet',
                'snippet' => [
                    'parentId' => $comment->comment_id,
                    'textOriginal' => $replyText,
                ],
            ]);

            if ($response->successful()) {
                $comment->update(['has_ai_reply' => true]);
                Log::info("Successfully posted reply to comment {$comment->comment_id}");
                return true;
            }

            Log::error('Failed to post YouTube comment reply', [
                'comment_id' => $comment->comment_id,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to post YouTube comment reply', [
                'comment_id' => $comment->comment_id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function getValidAccessToken(): ?string
    {
        $accessToken = \App\Models\Setting::get('youtube_access_token');
        $expiresAt = \App\Models\Setting::get('youtube_token_expires_at');

        if (! $accessToken || ! $expiresAt) {
            return null;
        }

        // Check if token is expired or will expire in the next 5 minutes
        if (now()->timestamp >= ($expiresAt - 300)) {
            return $this->refreshAccessToken();
        }

        return $accessToken;
    }

    private function refreshAccessToken(): ?string
    {
        $refreshToken = \App\Models\Setting::get('youtube_refresh_token');
        $clientId = config('services.youtube.oauth_client_id');
        $clientSecret = config('services.youtube.oauth_client_secret');

        if (! $refreshToken || ! $clientId || ! $clientSecret) {
            Log::error('Cannot refresh YouTube token: missing refresh token or credentials');
            return null;
        }

        try {
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'refresh_token' => $refreshToken,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'refresh_token',
            ]);

            if (! $response->successful()) {
                Log::error('Failed to refresh YouTube access token', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            \App\Models\Setting::set('youtube_access_token', $data['access_token']);
            \App\Models\Setting::set('youtube_token_expires_at', now()->addSeconds($data['expires_in'])->timestamp);

            Log::info('Successfully refreshed YouTube access token');
            return $data['access_token'];
        } catch (\Exception $e) {
            Log::error('Failed to refresh YouTube access token', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
