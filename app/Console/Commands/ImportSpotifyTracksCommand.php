<?php

namespace App\Console\Commands;

use App\Services\SpotifyService;
use Illuminate\Console\Command;

class ImportSpotifyTracksCommand extends Command
{
    protected $signature = 'spotify:import-tracks';

    protected $description = 'Import all saved tracks from Spotify';

    public function handle(SpotifyService $spotifyService): void
    {
        if (! $spotifyService->isAuthorized()) {
            $this->error('Spotify is not authorized. Please authorize first by visiting /spotify/authorize');
            return;
        }

        $this->info('Starting Spotify tracks import...');

        $count = $spotifyService->syncSavedTracks();

        $this->comment("Successfully imported {$count} tracks from Spotify!");
    }
}
