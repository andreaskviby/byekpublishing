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

        $seoData = [
            'title' => 'Music Releases | By Ek Publishing - Experimental AI-Assisted Music',
            'description' => 'Discover experimental AI-assisted music releases by Linda Ettehag Kviby. Explore innovative soundscapes blending human creativity with artificial intelligence on Spotify, Apple Music, and more.',
            'keywords' => 'Linda Ettehag Kviby music, AI-assisted music, experimental music, AI music collaboration, Swedish music, indie music releases, Spotify artist',
            'image' => $musicReleases->first()?->album_cover_url ?? asset('images/default-og-image.jpg'),
            'url' => route('music'),
            'type' => 'music.song',
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
            'name' => 'Music Releases - By Ek Publishing',
            'description' => 'Experimental AI-assisted music releases by Linda Ettehag Kviby',
            'numberOfItems' => $musicReleases->count(),
            'itemListElement' => $musicReleases->map(function ($release, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => [
                        '@type' => 'MusicRecording',
                        '@id' => route('music.detail', $release),
                        'name' => $release->title,
                        'description' => $release->meta_description,
                        'image' => $release->album_cover_url,
                        'byArtist' => [
                            '@type' => 'Person',
                            'name' => $release->artist_name,
                        ],
                        'datePublished' => $release->release_date?->format('Y-m-d'),
                        'recordingOf' => [
                            '@type' => 'MusicComposition',
                            'name' => $release->title,
                        ],
                    ],
                ];
            })->values()->all(),
        ];

        return view('livewire.music-page', [
            'musicReleases' => $musicReleases,
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
