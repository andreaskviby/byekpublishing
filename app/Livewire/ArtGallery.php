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

        $seoData = [
            'title' => 'Art Gallery | Linda Ettehag Kviby - Swedish Artist',
            'description' => 'Explore the visual artworks of Swedish artist Linda Ettehag Kviby. Browse original paintings and artwork featuring emotional depth and unique artistic expression.',
            'keywords' => 'Linda Ettehag Kviby art, Swedish artist, paintings, visual artwork, contemporary art, original artwork, Swedish contemporary artist',
            'image' => $artPieces->first()?->image_url ?? asset('images/default-og-image.jpg'),
            'url' => route('art-gallery'),
            'type' => 'website',
            'author' => 'Linda Ettehag Kviby',
            'site_name' => 'By Ek Publishing',
            'twitter:card' => 'summary_large_image',
            'twitter:site' => '@lindaettehagkviby',
            'twitter:creator' => '@lindaettehagkviby',
            'og:image:width' => '1200',
            'og:image:height' => '630',
            'og:locale' => 'sv_SE',
        ];

        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Art Gallery - Linda Ettehag Kviby',
            'description' => 'Visual artworks by Swedish artist Linda Ettehag Kviby',
            'numberOfItems' => $artPieces->count(),
            'itemListElement' => $artPieces->map(function ($artPiece, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => [
                        '@type' => 'VisualArtwork',
                        '@id' => route('art.detail', $artPiece),
                        'name' => $artPiece->title,
                        'description' => $artPiece->description,
                        'image' => $artPiece->image_url,
                        'artform' => 'Painting',
                        'artMedium' => $artPiece->medium,
                        'dateCreated' => $artPiece->year,
                        'creator' => [
                            '@type' => 'Person',
                            'name' => 'Linda Ettehag Kviby',
                            'url' => route('author'),
                        ],
                    ],
                ];
            })->values()->all(),
        ];

        return view('livewire.art-gallery', [
            'artPieces' => $artPieces,
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
