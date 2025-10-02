<div>
    @push('meta')
        <meta name="description" content="{{ $seoData['description'] }}">
        <meta name="keywords" content="{{ $seoData['keywords'] }}">
        <meta name="author" content="{{ $seoData['author'] }}">
        <link rel="canonical" href="{{ $seoData['url'] }}">
        
        <!-- Open Graph Tags -->
        <meta property="og:type" content="{{ $seoData['type'] }}">
        <meta property="og:title" content="{{ $seoData['title'] }}">
        <meta property="og:description" content="{{ $seoData['description'] }}">
        <meta property="og:image" content="{{ $seoData['image'] }}">
        <meta property="og:url" content="{{ $seoData['url'] }}">
        <meta property="og:site_name" content="{{ $seoData['site_name'] }}">
        <meta property="og:video" content="https://www.youtube.com/watch?v={{ $youTubeVideo->youtube_id }}">
        
        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="player">
        <meta name="twitter:title" content="{{ $seoData['title'] }}">
        <meta name="twitter:description" content="{{ $seoData['description'] }}">
        <meta name="twitter:image" content="{{ $seoData['image'] }}">
        <meta name="twitter:player" content="https://www.youtube.com/embed/{{ $youTubeVideo->youtube_id }}">
        <meta name="twitter:player:width" content="560">
        <meta name="twitter:player:height" content="315">
        
        <!-- Structured Data -->
        <script type="application/ld+json">
            {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <!-- Breadcrumb -->
    <nav class="bg-gray-50 py-4" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2" vocab="https://schema.org/" typeof="BreadcrumbList">
                <li property="itemListElement" typeof="ListItem">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700" property="item" typeof="WebPage">
                        <span property="name">Home</span>
                    </a>
                    <meta property="position" content="1">
                </li>
                <li class="text-gray-500">/</li>
                <li property="itemListElement" typeof="ListItem">
                    <a href="{{ route('videos') }}" class="text-gray-500 hover:text-gray-700" property="item" typeof="WebPage">
                        <span property="name">Videos</span>
                    </a>
                    <meta property="position" content="2">
                </li>
                <li class="text-gray-500">/</li>
                <li property="itemListElement" typeof="ListItem">
                    <span class="text-gray-900 font-medium" property="name">{{ $youTubeVideo->title }}</span>
                    <meta property="position" content="3">
                </li>
            </ol>
        </div>
    </nav>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Video Player -->
                <div class="lg:col-span-2">
                    <header class="mb-6">
                        <h1 class="text-3xl font-display font-bold text-brown-900 mb-2">{{ $youTubeVideo->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span>Published: {{ $youTubeVideo->published_at->format('M d, Y') }}</span>
                            @if($youTubeVideo->view_count > 0)
                                <span>{{ number_format($youTubeVideo->view_count) }} views</span>
                            @endif
                            @if($youTubeVideo->duration)
                                <span>Duration: {{ $youTubeVideo->duration }}</span>
                            @endif
                        </div>
                    </header>

                    <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden mb-6">
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $youTubeVideo->youtube_id }}" 
                            title="{{ $youTubeVideo->title }}"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-full">
                        </iframe>
                    </div>

                    @if($youTubeVideo->description)
                        <div class="prose prose-lg max-w-none">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                            <div class="text-gray-700 whitespace-pre-line">{{ $youTubeVideo->description }}</div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Watch on YouTube -->
                    <div class="bg-red-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Watch on YouTube</h3>
                        <a href="https://www.youtube.com/watch?v={{ $youTubeVideo->youtube_id }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            Open in YouTube
                        </a>
                    </div>

                    <!-- Share Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this video</h3>
                        <div class="space-y-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($seoData['url']) }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Share on Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($seoData['url']) }}&text={{ urlencode($youTubeVideo->title . ' by Linda Ettehag Kviby') }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Share on Twitter
                            </a>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="bg-accent-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">About the Creator</h3>
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-lg">L</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Linda Ettehag Kviby</p>
                                <p class="text-sm text-gray-600">Author & Creative Artist</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-4">Swedish author and artist creating content that explores deep emotional themes through books, art, and multimedia.</p>
                        <a href="{{ route('author') }}" 
                           class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700">
                            Learn more about Linda
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
