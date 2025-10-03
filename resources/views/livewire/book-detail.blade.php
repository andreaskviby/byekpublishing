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

    <div class="bg-gradient-to-b from-accent-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Book Cover - Smaller and more elegant -->
                <div class="flex justify-center lg:justify-start">
                    <div class="w-72 shadow-2xl rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300">
                        @if($book->cover_image_url)
                            <img src="{{ $book->cover_image_url }}"
                                 alt="Cover of {{ $book->title }} by Linda Ettehag Kviby"
                                 class="w-full h-auto object-cover">
                        @else
                            <div class="aspect-[3/4] bg-gradient-to-br from-primary-200 to-accent-200 flex items-center justify-center">
                                <span class="text-6xl text-gray-400">📚</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Details -->
                <div class="space-y-6">
                    <header>
                        <h1 class="text-4xl font-display font-bold text-brown-900">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-600 mt-2">by Linda Ettehag Kviby</p>
                    </header>

                    @if($book->description)
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $book->description }}</p>
                        </div>
                    @endif

                    <div class="bg-accent-50 rounded-xl p-6 grid grid-cols-2 gap-6">
                        @if($book->isbn)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">🔖</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">ISBN</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $book->isbn }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($book->publication_date)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">📅</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Published</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $book->publication_date->format('F j, Y') }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($book->pages)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">📄</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pages</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $book->pages }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($book->genre)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">🏷️</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Genre</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $book->genre }}</dd>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Purchase Links -->
                    @if($book->purchaseLinks->count() > 0)
                        <div class="bg-gradient-to-br from-primary-50 to-accent-50 rounded-xl p-8 border-2 border-primary-200">
                            <h3 class="text-2xl font-display font-bold text-brown-900 mb-6 flex items-center">
                                <span class="mr-2">📚</span> Get this book
                            </h3>
                            <div class="space-y-4">
                                @foreach($book->purchaseLinks->groupBy('language_id') as $languageId => $links)
                                    @php $language = $links->first()->language; @endphp
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-700 mb-2">
                                            {{ $language->flag_emoji }} {{ $language->name }}
                                        </h4>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($links->where('is_active', true) as $link)
                                                <a href="{{ $link->url }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="inline-flex items-center px-5 py-3 bg-primary-600 text-white rounded-full hover:bg-primary-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 font-medium text-sm">
                                                    {{ $link->store_name }}
                                                    @if($link->format)
                                                        <span class="ml-2 text-xs opacity-80">({{ $link->format }})</span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Section -->
                    <div class="bg-gradient-to-r from-purple-50 via-pink-50 to-orange-50 rounded-xl p-8 shadow-md border-2 border-purple-100">
                        <h3 class="text-2xl font-display font-bold text-brown-900 mb-6 flex items-center">
                            <span class="mr-3 text-3xl">✨</span> Share this book
                        </h3>
                        <div class="flex gap-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($seoData['url']) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group flex-1 flex flex-col items-center justify-center p-4 rounded-xl bg-white hover:bg-blue-600 transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-1">
                                <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="mt-2 text-sm font-semibold text-gray-700 group-hover:text-white transition-colors duration-300">Facebook</span>
                            </a>
                            <a href="https://www.instagram.com/"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group flex-1 flex flex-col items-center justify-center p-4 rounded-xl bg-white hover:bg-gradient-to-br hover:from-purple-600 hover:via-pink-600 hover:to-orange-600 transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-1">
                                <svg class="w-8 h-8 text-pink-600 group-hover:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <span class="mt-2 text-sm font-semibold text-gray-700 group-hover:text-white transition-colors duration-300">Instagram</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews and Rating Section -->
            @if($totalReviews > 0 || true) {{-- Always show section so users can add reviews --}}
                <div class="mt-24 border-t-2 border-gray-300 pt-16">
                    <div class="max-w-5xl mx-auto">
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
