<?php

namespace App\Http\Controllers;

use App\Services\SpotifyService;
use Illuminate\Http\Request;

class SpotifyOAuthController extends Controller
{
    public function authorize(SpotifyService $spotifyService)
    {
        $authUrl = $spotifyService->getAuthorizationUrl();

        return redirect($authUrl);
    }

    public function callback(Request $request, SpotifyService $spotifyService)
    {
        $code = $request->get('code');

        if (! $code) {
            return response('Authorization failed: No code provided', 400);
        }

        $success = $spotifyService->handleCallback($code);

        if (! $success) {
            return response('Failed to exchange authorization code', 500);
        }

        return response()->view('spotify-oauth-success');
    }
}
