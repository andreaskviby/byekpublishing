<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YouTubeOAuthController extends Controller
{
    public function authorize()
    {
        $clientId = config('services.youtube.oauth_client_id');
        $redirectUri = config('app.env') === 'local'
            ? 'http://localhost:8000/youtube/oauth/callback'
            : route('youtube.oauth.callback');

        $authUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'https://www.googleapis.com/auth/youtube.force-ssl',
            'response_type' => 'code',
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');

        if (! $code) {
            return response('Authorization failed: No code provided', 400);
        }

        $clientId = config('services.youtube.oauth_client_id');
        $clientSecret = config('services.youtube.oauth_client_secret');
        $redirectUri = config('app.env') === 'local'
            ? 'http://localhost:8000/youtube/oauth/callback'
            : route('youtube.oauth.callback');

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        if (! $response->successful()) {
            return response('Failed to exchange authorization code: ' . $response->body(), 500);
        }

        $data = $response->json();

        Setting::set('youtube_access_token', $data['access_token']);
        Setting::set('youtube_refresh_token', $data['refresh_token']);
        Setting::set('youtube_token_expires_at', now()->addSeconds($data['expires_in'])->timestamp);

        return response()->view('youtube-oauth-success');
    }
}
