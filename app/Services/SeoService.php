<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class SeoService
{
    public static function generateMetaTags(Model $model, ?string $customTitle = null, ?string $customDescription = null): array
    {
        $title = $customTitle ?? $model->title ?? config('app.name');
        $description = $customDescription ?? $model->meta_description ?? $model->description ?? self::getDefaultDescription();
        $keywords = $model->meta_keywords ?? self::getDefaultKeywords();
        $image = self::getImageUrl($model);
        $url = self::getCurrentUrl();
        
        return [
            'title' => $title . ' | ' . config('app.name', 'By Ek Publishing'),
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
            'type' => self::getOpenGraphType($model),
            'author' => 'Linda Ettehag Kviby',
            'site_name' => config('app.name', 'By Ek Publishing'),
        ];
    }

    public static function generateStructuredData(Model $model): array
    {
        $baseData = [
            '@context' => 'https://schema.org',
            'url' => self::getCurrentUrl(),
            'name' => $model->title,
            'description' => $model->meta_description ?? $model->description,
            'image' => self::getImageUrl($model),
            'author' => [
                '@type' => 'Person',
                'name' => 'Linda Ettehag Kviby',
                'url' => route('author'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'By Ek Publishing',
                'url' => route('home'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
        ];

        return match (class_basename($model)) {
            'Book' => array_merge($baseData, [
                '@type' => 'Book',
                'isbn' => $model->isbn,
                'genre' => $model->genre,
                'numberOfPages' => $model->pages,
                'datePublished' => $model->publication_date?->format('Y-m-d'),
                'inLanguage' => 'sv-SE',
            ]),
            'BlogPost' => array_merge($baseData, [
                '@type' => 'Article',
                'headline' => $model->title,
                'datePublished' => $model->published_at?->format('c'),
                'dateModified' => $model->updated_at?->format('c'),
                'articleBody' => strip_tags($model->content),
                'wordCount' => str_word_count(strip_tags($model->content)),
                'inLanguage' => 'sv-SE',
            ]),
            'ArtPiece' => array_merge($baseData, [
                '@type' => 'CreativeWork',
                'artform' => 'Visual Art',
                'artMedium' => $model->medium,
                'dateCreated' => $model->year,
                'offers' => $model->is_available && $model->price ? [
                    '@type' => 'Offer',
                    'price' => $model->price,
                    'priceCurrency' => $model->currency ?? 'SEK',
                    'availability' => 'InStock',
                ] : null,
            ]),
            'MusicRelease' => array_merge($baseData, [
                '@type' => 'MusicRelease',
                'byArtist' => [
                    '@type' => 'Person',
                    'name' => $model->artist_name,
                ],
                'datePublished' => $model->release_date?->format('Y-m-d'),
                'recordLabel' => 'By Ek Publishing',
                'genre' => 'Alternative',
            ]),
            'YouTubeVideo' => array_merge($baseData, [
                '@type' => 'VideoObject',
                'embedUrl' => "https://www.youtube.com/embed/{$model->youtube_id}",
                'thumbnailUrl' => $model->thumbnail_url,
                'uploadDate' => $model->published_at?->format('c'),
                'duration' => $model->duration ? "PT{$model->duration}" : null,
                'interactionCount' => $model->view_count,
                'contentUrl' => "https://www.youtube.com/watch?v={$model->youtube_id}",
            ]),
            default => $baseData,
        };
    }

    private static function getImageUrl(Model $model): ?string
    {
        return match (class_basename($model)) {
            'Book' => $model->cover_image_url,
            'ArtPiece' => $model->image_url,
            'MusicRelease' => $model->album_cover_url,
            'YouTubeVideo' => $model->thumbnail_url,
            'BlogPost' => $model->featured_image ? asset('storage/' . $model->featured_image) : null,
            default => null,
        } ?? asset('images/default-og-image.jpg');
    }

    private static function getOpenGraphType(Model $model): string
    {
        return match (class_basename($model)) {
            'Book' => 'book',
            'BlogPost' => 'article',
            'YouTubeVideo' => 'video.other',
            'MusicRelease' => 'music.album',
            default => 'website',
        };
    }

    private static function getCurrentUrl(): string
    {
        return request()->url();
    }

    private static function getDefaultDescription(): string
    {
        return 'Discover books, art, and music by Linda Ettehag Kviby at By Ek Publishing. Explore creative works, watch videos, and connect with Swedish artistry.';
    }

    private static function getDefaultKeywords(): string
    {
        return 'Linda Ettehag Kviby, By Ek Publishing, Swedish author, books, art, music, creative works, publishing';
    }

    public static function generateOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'By Ek Publishing',
            'url' => route('home'),
            'logo' => asset('images/logo.png'),
            'description' => 'By Ek Publishing is the creative home of Linda Ettehag Kviby, featuring books, art, music, and multimedia content.',
            'founder' => [
                '@type' => 'Person',
                'name' => 'Linda Ettehag Kviby',
                'url' => route('author'),
            ],
            'sameAs' => [
                'https://www.youtube.com/@lindaettehaggkviby',
                // Add other social media URLs as needed
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'Sweden',
            ],
        ];
    }
}