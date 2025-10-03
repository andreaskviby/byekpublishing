<?php

namespace App\Livewire;

use App\Models\YouTubeVideo;
use App\Services\SeoService;
use Livewire\Component;

class VideoDetail extends Component
{
    public YouTubeVideo $youTubeVideo;

    public function mount(YouTubeVideo $youTubeVideo)
    {
        $this->youTubeVideo = $youTubeVideo;
    }

    public function render()
    {
        $seoData = SeoService::generateMetaTags($this->youTubeVideo);
        $structuredData = SeoService::generateStructuredData($this->youTubeVideo);

        return view('livewire.video-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')
          ->title($seoData['title']);
    }
}
