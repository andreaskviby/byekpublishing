<?php

namespace App\Livewire;

use App\Models\YouTubeVideo;
use Livewire\Component;

class VideosPage extends Component
{
    public function render()
    {
        $videos = YouTubeVideo::orderBy('published_at', 'desc')->get();

        return view('livewire.videos-page', [
            'videos' => $videos,
        ])->layout('layouts.app')->title('Videos');
    }
}
