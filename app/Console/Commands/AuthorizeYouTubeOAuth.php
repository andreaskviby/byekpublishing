<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AuthorizeYouTubeOAuth extends Command
{
    protected $signature = 'youtube:authorize';

    protected $description = 'Authorize YouTube OAuth access for posting comments';

    public function handle(): int
    {
        $clientId = config('services.youtube.oauth_client_id');
        $clientSecret = config('services.youtube.oauth_client_secret');
        $redirectUri = 'urn:ietf:wg:oauth:2.0:oob';

        if (! $clientId || ! $clientSecret) {
            $this->error('YouTube OAuth credentials not configured in .env file.');
            return self::FAILURE;
        }

        // Generate authorization URL
        $authUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'https://www.googleapis.com/auth/youtube.force-ssl',
            'response_type' => 'code',
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        $this->info('Please visit the following URL to authorize YouTube access:');
        $this->newLine();
        $this->line($authUrl);
        $this->newLine();

        $code = $this->ask('Enter the authorization code from Google');

        if (! $code) {
            $this->error('No authorization code provided.');
            return self::FAILURE;
        }

        $this->info('Exchanging authorization code for access token...');

        // Exchange code for tokens
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        if (! $response->successful()) {
            $this->error('Failed to exchange authorization code: ' . $response->body());
            return self::FAILURE;
        }

        $data = $response->json();

        // Store tokens
        Setting::set('youtube_access_token', $data['access_token']);
        Setting::set('youtube_refresh_token', $data['refresh_token']);
        Setting::set('youtube_token_expires_at', now()->addSeconds($data['expires_in'])->timestamp);

        $this->comment('Successfully authorized YouTube OAuth!');
        $this->info('Access token and refresh token have been stored.');

        return self::SUCCESS;
    }
}
