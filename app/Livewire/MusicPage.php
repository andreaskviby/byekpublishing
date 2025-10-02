<?php

namespace App\Livewire;

use App\Models\MusicRelease;
use Livewire\Component;

class MusicPage extends Component
{
    public function render()
    {
        $musicReleases = MusicRelease::where('is_published', true)
            ->orderBy('release_date', 'desc')
            ->get();

        return view('livewire.music-page', [
            'musicReleases' => $musicReleases,
        ])->layout('layouts.app')->title('Music');
    }
}
