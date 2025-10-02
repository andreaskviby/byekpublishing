<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('author') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('books') }}</loc>
        <lastmod>{{ \App\Models\Book::where('is_published', true)->max('updated_at')?->format('Y-m-d') ?? now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('art') }}</loc>
        <lastmod>{{ \App\Models\ArtPiece::where('is_available', true)->max('updated_at')?->format('Y-m-d') ?? now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('music') }}</loc>
        <lastmod>{{ \App\Models\MusicRelease::where('is_published', true)->max('updated_at')?->format('Y-m-d') ?? now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('videos') }}</loc>
        <lastmod>{{ \App\Models\YouTubeVideo::max('updated_at')?->format('Y-m-d') ?? now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <!-- Books -->
    @foreach(\App\Models\Book::where('is_published', true)->whereNotNull('slug')->get() as $book)
    <url>
        <loc>{{ route('book.detail', $book) }}</loc>
        <lastmod>{{ $book->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    <!-- Blog Posts -->
    @foreach(\App\Models\BlogPost::where('is_published', true)->whereNotNull('slug')->get() as $post)
    <url>
        <loc>{{ route('blog.detail', $post) }}</loc>
        <lastmod>{{ $post->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    <!-- Art Pieces -->
    @foreach(\App\Models\ArtPiece::where('is_available', true)->whereNotNull('slug')->get() as $art)
    <url>
        <loc>{{ route('art.detail', $art) }}</loc>
        <lastmod>{{ $art->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    <!-- Music Releases -->
    @foreach(\App\Models\MusicRelease::where('is_published', true)->whereNotNull('slug')->get() as $music)
    <url>
        <loc>{{ route('music.detail', $music) }}</loc>
        <lastmod>{{ $music->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    <!-- Videos -->
    @foreach(\App\Models\YouTubeVideo::whereNotNull('slug')->get() as $video)
    <url>
        <loc>{{ route('video.detail', $video) }}</loc>
        <lastmod>{{ $video->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>