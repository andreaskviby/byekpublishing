<?php

namespace App\Livewire;

use Livewire\Component;

class AuthorPage extends Component
{
    public function render()
    {
        $seoData = [
            'title' => 'About Linda Ettehag Kviby | Author, Artist & YouTuber',
            'description' => 'Linda Ettehag Kviby is a multi-talented author, artist, and creative explorer. Author of "Shadow of a Butterfly" - a psychological thriller exploring transformation and resilience.',
            'keywords' => 'Linda Ettehag Kviby, Swedish author, psychological thriller author, Shadow of a Butterfly, artist, YouTuber, creative writer, Swedish literature',
            'image' => asset('images/linda.jpeg'),
            'url' => route('author'),
            'type' => 'profile',
            'author' => 'Linda Ettehag Kviby',
            'site_name' => 'By Ek Publishing',
            'twitter:card' => 'summary_large_image',
            'twitter:site' => '@lindaettehagkviby',
            'twitter:creator' => '@lindaettehagkviby',
            'og:image:width' => '1200',
            'og:image:height' => '630',
            'og:locale' => 'en_US',
        ];

        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Linda Ettehag Kviby',
            'alternateName' => 'Linda Kviby',
            'jobTitle' => 'Author, Artist & YouTuber',
            'description' => 'Multi-talented author, artist, and creative explorer whose work speaks to the heart and soul.',
            'url' => route('author'),
            'image' => asset('images/linda.jpeg'),
            'sameAs' => [
                'https://instagram.com/lindaettehagkviby',
            ],
            'knowsAbout' => [
                'Creative Writing',
                'Psychological Thriller',
                'Visual Art',
                'Music Production',
            ],
        ];

        return view('livewire.author-page', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')->title($seoData['title']);
    }
}
