<?php

namespace App\Livewire;

use App\Models\YouTubeVideo;
use App\Services\SeoService;
use Illuminate\Support\Facades\Cache;
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

        // Cache comments for 30 minutes
        $comments = Cache::remember(
            "video_comments_{$this->youTubeVideo->id}",
            now()->addMinutes(30),
            fn() => $this->youTubeVideo->approvedComments()->get()
        );

        return view('livewire.video-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
            'comments' => $comments,
        ])->layout('layouts.app')
          ->title($seoData['title']);
    }
}
