<div>
    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-20 animate-gradient overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="animate-slide-in-left">
                    <h1 class="text-5xl font-display font-bold text-brown-900 mb-6 gradient-text">
                        Linda Ettehag Kviby
                    </h1>
                    <p class="text-xl text-gray-700 mb-8 italic animate-fade-in delay-200">
                        "Words that touch hearts, art that speaks to souls, and music that resonates with emotion."
                    </p>
                    <div class="flex space-x-4 animate-fade-in-up delay-300">
                        <a href="{{ route('books') }}"
                           class="bg-primary-600 text-white px-8 py-3 rounded-full hover:bg-primary-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 font-medium hover-glow">
                            Explore Books
                        </a>
                        <a href="{{ route('contact') }}"
                           class="border-2 border-primary-600 text-primary-600 px-8 py-3 rounded-full hover:bg-accent-50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 font-medium">
                            Get in Touch
                        </a>
                    </div>
                </div>
                <div class="flex justify-center animate-slide-in-right">
                    <div class="w-80 h-80 bg-gradient-to-br from-primary-300 to-accent-300 rounded-full flex items-center justify-center shadow-2xl animate-float hover:scale-105 transition-transform duration-500">
                        <span class="text-white text-6xl">📚</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($featuredBook)
    <section class="py-16 bg-white" x-data="{ show: false }" x-intersect="show = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-brown-900 mb-8 text-center"
                x-show="show"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 transform translate-y-8"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                Featured Book
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="flex justify-center"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-700 delay-200"
                     x-transition:enter-start="opacity-0 transform -translate-x-12"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="w-64 h-96 bg-gradient-to-br from-primary-200 to-accent-200 rounded-lg shadow-xl flex items-center justify-center image-zoom hover-lift">
                        @if($featuredBook->cover_image)
                            <img src="{{ asset($featuredBook->cover_image) }}" alt="{{ $featuredBook->title }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <span class="text-6xl">📖</span>
                        @endif
                    </div>
                </div>
                <div x-show="show"
                     x-transition:enter="transition ease-out duration-700 delay-400"
                     x-transition:enter-start="opacity-0 transform translate-x-12"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h3 class="text-3xl font-display font-bold text-brown-900 mb-4">{{ $featuredBook->title }}</h3>
                    <p class="text-gray-700 mb-6">{{ $featuredBook->description }}</p>
                    <a href="{{ route('books') }}"
                       class="inline-block bg-primary-600 text-white px-6 py-3 rounded-full hover:bg-primary-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 font-medium hover-glow">
                        View All Books
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="py-16 bg-accent-100" x-data="{ show: false }" x-intersect="show = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-brown-900 mb-8 text-center"
                x-show="show"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 transform translate-y-8"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                Latest Activity
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($activityFeed as $index => $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover-lift shadow-smooth image-zoom"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform translate-y-8"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         style="transition-delay: {{ ($index % 3) * 100 }}ms;">
                        @if($item['type'] === 'blog')
                            <div class="p-6">
                                <span class="inline-block bg-primary-100 text-brown-800 text-xs px-3 py-1 rounded-full mb-3">Blog Post</span>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $item['data']->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($item['data']->excerpt, 100) }}</p>
                                <p class="text-sm text-gray-500">{{ $item['date']->format('M d, Y') }}</p>
                            </div>
                        @elseif($item['type'] === 'youtube')
                            <div class="aspect-video bg-gray-200">
                                @if($item['data']->thumbnail_url)
                                    <img src="{{ $item['data']->thumbnail_url }}" alt="{{ $item['data']->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-6">
                                <span class="inline-block bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full mb-3">YouTube</span>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $item['data']->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $item['date']->format('M d, Y') }}</p>
                            </div>
                        @elseif($item['type'] === 'instagram')
                            <div class="aspect-square bg-gray-200">
                                <img src="{{ $item['data']->media_url }}" alt="Instagram post" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <span class="inline-block bg-accent-200 text-primary-800 text-xs px-3 py-1 rounded-full mb-3">Instagram</span>
                                <p class="text-gray-600 mb-2">{{ Str::limit($item['data']->caption, 100) }}</p>
                                <p class="text-sm text-gray-500">{{ $item['date']->format('M d, Y') }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-12">
                        <p>No activity to display yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @if($artPieces->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-brown-900 mb-8 text-center">Art Gallery Preview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($artPieces as $art)
                    <div class="bg-gray-100 rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="aspect-square bg-gradient-to-br from-primary-200 to-accent-200 flex items-center justify-center">
                            @if($art->image_path)
                                <img src="{{ $art->image_path }}" alt="{{ $art->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-6xl">🎨</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900">{{ $art->title }}</h3>
                            @if($art->price)
                                <p class="text-primary-600 font-medium">{{ number_format($art->price, 0) }} {{ $art->currency }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('art') }}"
                   class="inline-block bg-primary-600 text-white px-6 py-3 rounded-full hover:bg-primary-700 transition-colors font-medium">
                    View Full Gallery
                </a>
            </div>
        </div>
    </section>
    @endif

    @if($musicReleases->count() > 0)
    <section class="py-16 bg-accent-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-brown-900 mb-8 text-center">Music Releases</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($musicReleases as $music)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="aspect-square bg-gradient-to-br from-primary-300 to-accent-300 flex items-center justify-center">
                            @if($music->album_cover)
                                <img src="{{ $music->album_cover }}" alt="{{ $music->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-6xl">🎵</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $music->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ $music->artist_name }}</p>
                            <div class="flex space-x-2">
                                @if($music->spotify_url)
                                    <a href="{{ $music->spotify_url }}" target="_blank" class="text-green-600 hover:text-green-700">Spotify</a>
                                @endif
                                @if($music->apple_music_url)
                                    <a href="{{ $music->apple_music_url }}" target="_blank" class="text-primary-600 hover:text-primary-700">Apple Music</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
