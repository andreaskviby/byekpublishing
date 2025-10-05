<?php

namespace App\Console\Commands;

use App\Services\SpotifyService;
use Illuminate\Console\Command;

class SyncSpotifyArtistAlbumsCommand extends Command
{
    protected $signature = 'spotify:sync-artist {artistId?}';

    protected $description = 'Sync all albums from a Spotify artist';

    public function handle(SpotifyService $spotifyService): void
    {
        $artistId = $this->argument('artistId') ?? config('services.spotify.artist_id');

        if (! $artistId) {
            $this->error('No artist ID provided. Set SPOTIFY_ARTIST_ID in .env or pass as argument.');
            return;
        }

        $this->info("Syncing albums for artist ID: {$artistId}...");

        $count = $spotifyService->syncArtistAlbums($artistId);

        $this->comment("Successfully synced {$count} albums with cover images!");
    }
}
