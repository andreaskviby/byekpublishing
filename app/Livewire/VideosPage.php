<?php

namespace App\Livewire;

use App\Models\YouTubeVideo;
use App\Services\SeoService;
use Livewire\Component;

class VideosPage extends Component
{
    public function render()
    {
        $videos = YouTubeVideo::orderBy('published_at', 'desc')->get();

        $seoData = [
            'title' => 'We Bought an Adventure in Sicily | By Ek Publishing - Linda Ettehag Kviby',
            'description' => 'Follow Linda Ettehag Kviby\'s Sicily adventure on YouTube. Watch as we traded our Swedish summer house for a large town house in Termini Imerese, Sicily. Join our journey learning Italian culture, language, and making Sicilian friends in our Mediterranean home.',
            'keywords' => 'Sicily adventure, Linda Ettehag Kviby, Termini Imerese, Swedish in Sicily, Italy living, Mediterranean lifestyle, Italian culture, Sicily videos, expat life Italy, Sicily house renovation',
            'image' => asset('images/default-og-image.jpg'),
            'url' => route('videos'),
            'type' => 'website',
            'author' => 'Linda Ettehag Kviby',
            'site_name' => 'By Ek Publishing',
        ];

        return view('livewire.videos-page', [
            'videos' => $videos,
            'seoData' => $seoData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
