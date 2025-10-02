<?php

namespace App\Console\Commands;

use App\Services\InstagramService;
use Illuminate\Console\Command;

class SyncInstagramPosts extends Command
{
    protected $signature = 'sync:instagram';

    protected $description = 'Sync Instagram posts from the configured account';

    public function handle(InstagramService $instagramService): int
    {
        $this->info('Starting Instagram post sync...');

        $count = $instagramService->syncPosts();

        if ($count === 0) {
            $this->warn('No posts synced. Check your Instagram API credentials.');
            return self::FAILURE;
        }

        $this->comment("Successfully synced {$count} posts from Instagram.");
        return self::SUCCESS;
    }
}
