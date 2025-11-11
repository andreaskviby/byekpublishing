<?php

namespace App\Console\Commands;

use App\Services\YouTubeService;
use Illuminate\Console\Command;

class GetYouTubeSubscribers extends Command
{
    protected $signature = 'youtube:subscribers {--cached : Use cached count instead of fresh API call}';
    protected $description = 'Get the current YouTube channel subscriber count';

    public function handle(YouTubeService $youtubeService): int
    {
        $this->info('Fetching YouTube subscriber count...');

        if ($this->option('cached')) {
            $count = $youtubeService->getCachedSubscriberCount();
            $this->info('Using cached subscriber count (1 hour cache)');
        } else {
            $count = $youtubeService->getSubscriberCount();
            $this->info('Fetching fresh subscriber count from YouTube API');
        }

        if ($count === null) {
            $this->error('Could not retrieve subscriber count.');
            $this->line('Please ensure your YouTube API credentials are configured:');
            $this->line('1. Add YOUTUBE_API_KEY to your .env file');
            $this->line('2. Add YOUTUBE_CHANNEL_ID to your .env file');
            $this->line('3. Make sure the YouTube Data API v3 is enabled in your Google Cloud project');
            return Command::FAILURE;
        }

        $this->info("Current subscriber count: " . number_format($count));
        
        return Command::SUCCESS;
    }
}
