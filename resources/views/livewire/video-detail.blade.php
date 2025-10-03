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
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Video Player -->
                <div class="lg:col-span-4">
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
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            Open in YouTube
                        </a>
                    </div>

                    <!-- Share Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this video</h3>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($seoData['url']) }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <svg class="w-3.5 h-3.5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Share on Facebook
                        </a>
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

            <!-- Comments Section -->
            @if($comments->count() > 0)
                <div class="mt-16 max-w-4xl mx-auto">
                    <h2 class="text-2xl font-display font-bold text-brown-900 mb-8">Comments ({{ $comments->count() }})</h2>
                    <div class="space-y-6">
                        @foreach($comments as $comment)
                            <div class="bg-white rounded-lg p-6 shadow-md">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center text-white font-semibold">
                                            {{ substr($comment->author_name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-900">{{ $comment->author_name }}</h3>
                                            <span class="text-sm text-gray-500">{{ $comment->published_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-gray-700 whitespace-pre-line">{!! nl2br(e($comment->comment_text)) !!}</div>
                                        @if($comment->like_count > 0)
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                                </svg>
                                                {{ $comment->like_count }} {{ $comment->like_count === 1 ? 'like' : 'likes' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Call to Action -->
            <div class="mt-16">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-2xl font-display font-bold text-brown-900 mb-8 text-center">Join Our Sicilian Adventure</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- YouTube CTA -->
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                            <div class="mb-3">
                                <svg class="w-12 h-12 mx-auto text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Subscribe on YouTube</h3>
                            <p class="text-gray-700 text-sm mb-4">Never miss a Sicily adventure!</p>
                            <a href="https://www.youtube.com/@WeBoughtAnAdventureInSicily"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-block bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition-colors font-semibold text-sm">
                                Subscribe Now
                            </a>
                        </div>

                        <!-- Patreon CTA -->
                        <div class="bg-gradient-to-br from-orange-50 to-pink-100 rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                            <div class="mb-3">
                                <svg class="w-12 h-12 mx-auto text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.386.524c-4.764 0-8.64 3.876-8.64 8.64 0 4.75 3.876 8.613 8.64 8.613 4.75 0 8.614-3.864 8.614-8.613C24 4.4 20.136.524 15.386.524M.003 23.537h4.22V.524H.003"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Support on Patreon</h3>
                            <p class="text-gray-700 text-sm mb-4">Get exclusive behind-the-scenes content!</p>
                            <a href="https://www.patreon.com/c/WeBoughtAnAdventureInSicily"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-block bg-orange-600 text-white px-6 py-2 rounded-full hover:bg-orange-700 transition-colors font-semibold text-sm">
                                Become a Patron
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
