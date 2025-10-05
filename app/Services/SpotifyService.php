<?php

namespace App\Services;

use App\Models\MusicRelease;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    private ?string $clientId;
    private ?string $clientSecret;
    private ?string $redirectUri;
    private Session $session;
    private SpotifyWebAPI $api;

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
        $this->redirectUri = config('services.spotify.redirect_uri');

        $this->session = new Session(
            $this->clientId,
            $this->clientSecret,
            $this->redirectUri
        );

        $this->api = new SpotifyWebAPI();
    }

    public function getAuthorizationUrl(): string
    {
        $options = [
            'scope' => [
                'user-library-read',
                'playlist-read-private',
                'playlist-read-collaborative',
            ],
        ];

        return $this->session->getAuthorizeUrl($options);
    }

    public function handleCallback(string $code): bool
    {
        try {
            $this->session->requestAccessToken($code);

            $accessToken = $this->session->getAccessToken();
            $refreshToken = $this->session->getRefreshToken();
            $expiresAt = now()->addSeconds(3600)->timestamp;

            Setting::set('spotify_access_token', $accessToken);
            Setting::set('spotify_refresh_token', $refreshToken);
            Setting::set('spotify_token_expires_at', $expiresAt);

            Log::info('Spotify OAuth tokens stored successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to exchange Spotify authorization code', ['error' => $e->getMessage()]);
            return false;
        }
    }

    private function getValidAccessToken(): ?string
    {
        $accessToken = Setting::get('spotify_access_token');
        $expiresAt = Setting::get('spotify_token_expires_at');

        if (! $accessToken || ! $expiresAt) {
            return null;
        }

        if (now()->timestamp >= ($expiresAt - 300)) {
            return $this->refreshAccessToken();
        }

        return $accessToken;
    }

    private function refreshAccessToken(): ?string
    {
        $refreshToken = Setting::get('spotify_refresh_token');

        if (! $refreshToken) {
            Log::error('Cannot refresh Spotify token: missing refresh token');
            return null;
        }

        try {
            $this->session->refreshAccessToken($refreshToken);

            $accessToken = $this->session->getAccessToken();
            $expiresAt = now()->addSeconds(3600)->timestamp;

            Setting::set('spotify_access_token', $accessToken);
            Setting::set('spotify_token_expires_at', $expiresAt);

            Log::info('Successfully refreshed Spotify access token');
            return $accessToken;
        } catch (\Exception $e) {
            Log::error('Failed to refresh Spotify access token', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function syncSavedTracks(): int
    {
        $accessToken = $this->getValidAccessToken();

        if (! $accessToken) {
            Log::warning('Spotify OAuth not authorized. Run: php artisan spotify:authorize');
            return 0;
        }

        $this->api->setAccessToken($accessToken);

        try {
            $count = 0;
            $offset = 0;
            $limit = 50;

            do {
                $tracks = $this->api->getMySavedTracks([
                    'limit' => $limit,
                    'offset' => $offset,
                ]);

                foreach ($tracks->items as $item) {
                    $this->storeTrack($item->track);
                    $count++;
                }

                $offset += $limit;
            } while ($tracks->next);

            Log::info("Synced {$count} tracks from Spotify");
            return $count;
        } catch (\Exception $e) {
            Log::error('Spotify sync failed', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    private function storeTrack(object $track): void
    {
        $artists = array_map(fn($artist) => $artist->name, $track->artists);
        $artistName = implode(', ', $artists);

        $albumCover = $track->album->images[0]->url ?? null;

        MusicRelease::updateOrCreate(
            ['spotify_id' => $track->id],
            [
                'title' => $track->name,
                'artist_name' => $artistName,
                'album_cover' => $albumCover,
                'release_type' => $track->album->album_type ?? 'single',
                'release_date' => $track->album->release_date ?? now(),
                'spotify_url' => $track->external_urls->spotify ?? null,
                'is_published' => true,
            ]
        );
    }

    public function isAuthorized(): bool
    {
        return Setting::get('spotify_access_token') !== null;
    }

    private function getClientCredentialsToken(): ?string
    {
        $cachedToken = Setting::get('spotify_client_token');
        $expiresAt = Setting::get('spotify_client_token_expires_at');

        if ($cachedToken && $expiresAt && now()->timestamp < ($expiresAt - 300)) {
            return $cachedToken;
        }

        try {
            $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if (! $response->successful()) {
                Log::error('Failed to get Spotify client credentials token', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();
            $accessToken = $data['access_token'];
            $expiresAt = now()->addSeconds($data['expires_in'])->timestamp;

            Setting::set('spotify_client_token', $accessToken);
            Setting::set('spotify_client_token_expires_at', $expiresAt);

            return $accessToken;
        } catch (\Exception $e) {
            Log::error('Failed to get Spotify client credentials token', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function syncArtistAlbums(string $artistId): int
    {
        $accessToken = $this->getClientCredentialsToken();

        if (! $accessToken) {
            Log::error('Failed to get Spotify access token');
            return 0;
        }

        try {
            $count = 0;
            $offset = 0;
            $limit = 50;

            do {
                $response = Http::withToken($accessToken)->get("https://api.spotify.com/v1/artists/{$artistId}/albums", [
                    'limit' => $limit,
                    'offset' => $offset,
                    'include_groups' => 'album,single,compilation',
                ]);

                if (! $response->successful()) {
                    Log::error('Failed to fetch artist albums', [
                        'artist_id' => $artistId,
                        'status' => $response->status(),
                        'response' => $response->body(),
                    ]);
                    break;
                }

                $data = $response->json();

                foreach ($data['items'] ?? [] as $album) {
                    $this->storeAlbum($album);
                    $count++;
                }

                $offset += $limit;
                $hasNext = isset($data['next']) && $data['next'] !== null;
            } while ($hasNext);

            Log::info("Synced {$count} albums from Spotify artist {$artistId}");
            return $count;
        } catch (\Exception $e) {
            Log::error('Failed to sync artist albums', [
                'artist_id' => $artistId,
                'error' => $e->getMessage(),
            ]);
            return 0;
        }
    }

    private function downloadAndSaveImage(string $imageUrl): ?string
    {
        try {
            $response = Http::get($imageUrl);

            if (! $response->successful()) {
                return null;
            }

            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'album-covers/' . Str::random(40) . '.' . $extension;

            Storage::disk('public')->put($filename, $response->body());

            return $filename;
        } catch (\Exception $e) {
            Log::error('Failed to download album cover', [
                'url' => $imageUrl,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    private function storeAlbum(array $album): void
    {
        $artists = array_map(fn($artist) => $artist['name'], $album['artists'] ?? []);
        $artistName = implode(', ', $artists);

        $albumCoverUrl = $album['images'][0]['url'] ?? null;
        $albumCoverPath = null;

        if ($albumCoverUrl) {
            $albumCoverPath = $this->downloadAndSaveImage($albumCoverUrl);
        }

        MusicRelease::updateOrCreate(
            ['spotify_id' => $album['id']],
            [
                'title' => $album['name'],
                'artist_name' => $artistName,
                'album_cover' => $albumCoverPath,
                'release_type' => $album['album_type'] ?? 'album',
                'release_date' => $album['release_date'] ?? now(),
                'spotify_url' => $album['external_urls']['spotify'] ?? null,
                'is_published' => true,
            ]
        );
    }
}
