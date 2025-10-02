<?php

namespace App\Livewire;

use App\Models\ArtPiece;
use Livewire\Component;

class ArtGallery extends Component
{
    public function render()
    {
        $artPieces = ArtPiece::where('is_available', true)
            ->orderBy('sort_order')
            ->get();

        return view('livewire.art-gallery', [
            'artPieces' => $artPieces,
        ])->layout('layouts.app')->title('Art Gallery');
    }
}
