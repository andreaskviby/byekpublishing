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
            'title' => 'We Bought an Adventure in Sicily | Inspired by Husdrömmar Sicilien | By Ek Publishing',
            'description' => 'Follow Linda Ettehag Kviby\'s Sicily adventure in Termini Imerese. Inspired by Bill and Marie Olsson Nylander from Husdrömmar Sicilien and their renovation of Palazzo Cirillo. Watch our journey learning Italian culture, language, and living the Mediterranean dream in Sicily.',
            'keywords' => 'Husdrömmar Sicilien, Bill Nylander, Marie Olsson Nylander, Palazzo Cirillo, Termini Imerese, Sicily adventure, Linda Ettehag Kviby, Swedish in Sicily, Italy living, Sicily house renovation, SVT Husdrömmar, Swedish expats Sicily',
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
