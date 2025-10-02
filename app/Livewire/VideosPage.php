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
            'title' => 'Videos | By Ek Publishing - Linda Ettehag Kviby',
            'description' => 'Watch Linda Ettehag Kviby\'s latest videos. Explore creative content, book discussions, and artistic insights from Swedish author and artist.',
            'keywords' => 'Linda Ettehag Kviby videos, YouTube, creative content, Swedish author videos, book discussions, artistic insights',
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
