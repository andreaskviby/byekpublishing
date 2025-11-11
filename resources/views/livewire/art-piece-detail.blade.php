<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
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
                    <a href="{{ route('art') }}" class="text-gray-500 hover:text-gray-700" property="item" typeof="WebPage">
                        <span property="name">Art Gallery</span>
                    </a>
                    <meta property="position" content="2">
                </li>
                <li class="text-gray-500">/</li>
                <li property="itemListElement" typeof="ListItem">
                    <span class="text-gray-900 font-medium" property="name">{{ $artPiece->title }}</span>
                    <meta property="position" content="3">
                </li>
            </ol>
        </div>
    </nav>

    <div class="bg-gradient-to-b from-accent-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                <!-- Artwork Image -->
                <div class="flex flex-col items-center">
                    <div class="w-full shadow-2xl rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300">
                        @if($artPiece->image_url)
                            <img src="{{ $artPiece->image_url }}"
                                 alt="{{ $artPiece->title }} by Linda Ettehag Kviby"
                                 class="w-full h-auto object-cover">
                        @else
                            <div class="aspect-square bg-gradient-to-br from-primary-200 to-accent-200 flex items-center justify-center">
                                <span class="text-6xl text-gray-400">🎨</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Artwork Details -->
                <div class="space-y-6">
                    <header>
                        <h1 class="text-4xl font-display font-bold text-brown-900">{{ $artPiece->title }}</h1>
                        <p class="text-xl text-gray-600 mt-2">by Linda Ettehag Kviby</p>
                    </header>

                    @if($artPiece->description)
                        <div class="bg-white rounded-xl p-6 shadow-md">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $artPiece->description }}</p>
                        </div>
                    @endif

                    <div class="bg-white rounded-xl p-6 shadow-md space-y-4">
                        @if($artPiece->medium)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">🖌️</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Medium</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $artPiece->medium }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($artPiece->dimensions)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">📏</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dimensions</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $artPiece->dimensions }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($artPiece->year)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">📅</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Year</dt>
                                    <dd class="text-base text-gray-900 font-medium mt-1">{{ $artPiece->year }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($artPiece->price)
                            <div class="flex items-start space-x-3">
                                <span class="text-2xl">💰</span>
                                <div>
                                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Price</dt>
                                    <dd class="text-2xl text-primary-600 font-bold mt-1">{{ number_format($artPiece->price, 0) }} {{ $artPiece->currency }}</dd>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Inquire Section -->
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <h3 class="text-2xl font-display font-bold text-brown-900 mb-4 flex items-center">
                            <span class="mr-2">💬</span> Interested in this piece?
                        </h3>
                        <p class="text-gray-700 mb-6">Contact us to inquire about purchasing this artwork or to learn more about it.</p>
                        <a href="{{ route('contact', ['art' => $artPiece->title]) }}"
                           class="inline-flex items-center px-8 py-3 bg-primary-600 text-white rounded-full hover:bg-primary-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 font-medium">
                            Send Inquiry
                        </a>
                    </div>

                    <!-- Share Section -->
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <h3 class="text-2xl font-display font-bold text-brown-900 mb-6 flex items-center">
                            <span class="mr-3 text-3xl">✨</span> Share this artwork
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
        </div>
    </div>
</div>
