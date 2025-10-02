<?php

namespace Database\Seeders;

use App\Services\YouTubeService;
use Illuminate\Database\Seeder;

class YouTubeVideoSeeder extends Seeder
{
    public function run(YouTubeService $youtubeService): void
    {
        // Sync videos from YouTube channel
        $this->command->info('Syncing YouTube videos...');
        $count = $youtubeService->syncVideos();
        $this->command->info("Synced {$count} videos from YouTube.");
    }
}
