<?php

namespace App\Livewire;

use App\Models\MusicRelease;
use App\Services\SeoService;
use Illuminate\Support\Str;
use Livewire\Component;

class MusicReleaseDetail extends Component
{
    public MusicRelease $musicRelease;

    public function mount(MusicRelease $musicRelease): void
    {
        if (!$musicRelease->is_published) {
            abort(404);
        }

        $this->musicRelease = $musicRelease;
    }

    public function render()
    {
        $seoData = SeoService::generateMetaTags(
            $this->musicRelease,
            $this->musicRelease->title . ' - ' . $this->musicRelease->artist_name,
            $this->musicRelease->meta_description ?? "Listen to {$this->musicRelease->title} by {$this->musicRelease->artist_name}. Experimental AI-assisted music available on Spotify, Apple Music, and YouTube Music."
        );

        $structuredData = SeoService::generateStructuredData($this->musicRelease);

        return view('livewire.music-release-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
