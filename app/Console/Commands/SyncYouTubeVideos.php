<?php

namespace App\Console\Commands;

use App\Services\YouTubeService;
use Illuminate\Console\Command;

class SyncYouTubeVideos extends Command
{
    protected $signature = 'sync:youtube';

    protected $description = 'Sync YouTube videos from the configured channel';

    public function handle(YouTubeService $youtubeService): int
    {
        $this->info('Starting YouTube video sync...');

        $count = $youtubeService->syncVideos();

        if ($count === 0) {
            $this->warn('No videos synced. Check your YouTube API credentials.');
            return self::FAILURE;
        }

        $this->comment("Successfully synced {$count} videos from YouTube.");
        return self::SUCCESS;
    }
}
