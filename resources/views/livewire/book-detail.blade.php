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
        
        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seoData['title'] }}">
        <meta name="twitter:description" content="{{ $seoData['description'] }}">
        <meta name="twitter:image" content="{{ $seoData['image'] }}">
        
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
                    <a href="{{ route('books') }}" class="text-gray-500 hover:text-gray-700" property="item" typeof="WebPage">
                        <span property="name">Books</span>
                    </a>
                    <meta property="position" content="2">
                </li>
                <li class="text-gray-500">/</li>
                <li property="itemListElement" typeof="ListItem">
                    <span class="text-gray-900 font-medium" property="name">{{ $book->title }}</span>
                    <meta property="position" content="3">
                </li>
            </ol>
        </div>
    </nav>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Book Cover -->
                <div class="aspect-[3/4] bg-gray-200 rounded-lg overflow-hidden">
                    @if($book->cover_image_url)
                        <img src="{{ $book->cover_image_url }}" 
                             alt="Cover of {{ $book->title }} by Linda Ettehag Kviby" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-6xl text-gray-400">📚</span>
                        </div>
                    @endif
                </div>

                <!-- Book Details -->
                <div class="space-y-6">
                    <header>
                        <h1 class="text-4xl font-display font-bold text-brown-900">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-600 mt-2">by Linda Ettehag Kviby</p>
                    </header>

                    @if($book->description)
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 py-6 border-t border-b border-gray-200">
                        @if($book->isbn)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                                <dd class="text-sm text-gray-900">{{ $book->isbn }}</dd>
                            </div>
                        @endif
                        
                        @if($book->publication_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Publication Date</dt>
                                <dd class="text-sm text-gray-900">{{ $book->publication_date->format('F j, Y') }}</dd>
                            </div>
                        @endif
                        
                        @if($book->pages)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pages</dt>
                                <dd class="text-sm text-gray-900">{{ $book->pages }}</dd>
                            </div>
                        @endif
                        
                        @if($book->genre)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Genre</dt>
                                <dd class="text-sm text-gray-900">{{ $book->genre }}</dd>
                            </div>
                        @endif
                    </div>

                    <!-- Purchase Links -->
                    @if($book->purchaseLinks->count() > 0)
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Get this book</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($book->purchaseLinks as $link)
                                    <a href="{{ $link->url }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                                        {{ $link->platform }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this book</h3>
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($seoData['url']) }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-blue-600 hover:text-blue-700">
                                <span class="sr-only">Share on Facebook</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($seoData['url']) }}&text={{ urlencode($book->title . ' by Linda Ettehag Kviby') }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-blue-400 hover:text-blue-500">
                                <span class="sr-only">Share on Twitter</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews and Rating Section -->
            @if($totalReviews > 0 || true) {{-- Always show section so users can add reviews --}}
                <div class="mt-16 border-t border-gray-200 pt-16">
                    <div class="max-w-4xl mx-auto">
                        <!-- Reviews Header -->
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-display font-bold text-brown-900 mb-4">Reader Reviews</h2>
                            @if($totalReviews > 0)
                                <div class="flex items-center justify-center space-x-4">
                                    <!-- Average Rating Display -->
                                    <div class="flex items-center space-x-2">
                                        <span class="text-2xl">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($averageRating))
                                                    🦋
                                                @else
                                                    <span class="text-gray-300">🤍</span>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="text-lg font-semibold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                                    </div>
                                    <div class="text-gray-600">
                                        <span class="font-medium">{{ $totalReviews }}</span> 
                                        {{ $totalReviews === 1 ? 'review' : 'reviews' }}
                                    </div>
                                </div>

                                <!-- Rating Breakdown -->
                                <div class="mt-6 max-w-sm mx-auto">
                                    @for($rating = 5; $rating >= 1; $rating--)
                                        @php $count = $ratingCounts[$rating] ?? 0; @endphp
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span class="text-sm w-3">{{ $rating }}</span>
                                            <span class="text-lg">🦋</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-primary-600 h-2 rounded-full" 
                                                     style="width: {{ $totalReviews > 0 ? ($count / $totalReviews * 100) : 0 }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600 w-8">{{ $count }}</span>
                                        </div>
                                    @endfor
                                </div>
                            @else
                                <p class="text-gray-600">Be the first to share your thoughts about this book!</p>
                            @endif
                        </div>

                        <!-- Review Form -->
                        <div class="mb-16">
                            <livewire:book-review-form :book="$book" />
                        </div>

                        <!-- Existing Reviews -->
                        @if($totalReviews > 0)
                            <div class="space-y-8">
                                <h3 class="text-2xl font-display font-bold text-brown-900 mb-6">What readers are saying</h3>
                                
                                @foreach($reviewsByLanguage as $languageName => $reviews)
                                    @if($reviews->count() > 0)
                                        <div class="mb-8">
                                            @if($reviewsByLanguage->count() > 1)
                                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                                    <span class="mr-2">{{ $reviews->first()->language->flag_emoji ?? '🌍' }}</span>
                                                    Reviews in {{ $languageName }}
                                                </h4>
                                            @endif
                                            
                                            <div class="grid gap-6">
                                                @foreach($reviews as $review)
                                                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                                        <!-- Review Header -->
                                                        <div class="flex items-start justify-between mb-4">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="flex-shrink-0">
                                                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                                                                        {{ substr($review->reviewer_signature ?: 'A', 0, 1) }}
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="font-medium text-gray-900">
                                                                        {{ $review->reviewer_signature ?: 'Anonymous Reader' }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $review->submitted_at->format('F j, Y') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center text-lg">
                                                                {!! $review->butterfly_rating !!}
                                                            </div>
                                                        </div>

                                                        <!-- Review Content -->
                                                        @if($review->review_text)
                                                            <div class="text-gray-700 leading-relaxed">
                                                                <p>{{ $review->review_text }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
