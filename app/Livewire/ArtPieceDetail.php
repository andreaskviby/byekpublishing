<?php

namespace App\Livewire;

use App\Models\ArtPiece;
use App\Services\SeoService;
use Illuminate\Support\Str;
use Livewire\Component;

class ArtPieceDetail extends Component
{
    public ArtPiece $artPiece;

    public function mount(ArtPiece $artPiece): void
    {
        if (!$artPiece->is_available) {
            abort(404);
        }

        $this->artPiece = $artPiece;
    }

    public function render()
    {
        $seoData = SeoService::generateMetaTags(
            $this->artPiece,
            $this->artPiece->title,
            $this->artPiece->meta_description ?? Str::limit(strip_tags($this->artPiece->description), 155)
        );

        $structuredData = SeoService::generateStructuredData($this->artPiece);

        return view('livewire.art-piece-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
