<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center">Art Gallery</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">Original artwork available for inquiry and purchase</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($artPieces as $art)
                    <div class="bg-accent-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <a href="{{ route('art.detail', $art) }}" class="block aspect-square bg-gradient-to-br from-primary-200 to-accent-200 flex items-center justify-center hover:opacity-90 transition-opacity">
                            @if($art->image_url)
                                <img src="{{ $art->image_url }}" alt="{{ $art->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-6xl">🎨</span>
                            @endif
                        </a>
                        <div class="p-6">
                            <a href="{{ route('art.detail', $art) }}" class="block hover:text-primary-600 transition-colors">
                                <h3 class="text-xl font-semibold text-brown-900 mb-2">{{ $art->title }}</h3>
                            </a>
                            @if($art->description)
                                <p class="text-gray-600 mb-3">{{ Str::limit($art->description, 100) }}</p>
                            @endif
                            <div class="space-y-1 text-sm text-gray-600">
                                @if($art->medium)
                                    <p><strong>Medium:</strong> {{ $art->medium }}</p>
                                @endif
                                @if($art->dimensions)
                                    <p><strong>Dimensions:</strong> {{ $art->dimensions }}</p>
                                @endif
                                @if($art->year)
                                    <p><strong>Year:</strong> {{ $art->year }}</p>
                                @endif
                            </div>
                            @if($art->price)
                                <p class="text-xl font-semibold text-primary-600 mt-4">{{ number_format($art->price, 0) }} {{ $art->currency }}</p>
                            @endif
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('art.detail', $art) }}" class="inline-block flex-1 text-center bg-brown-900 text-white px-4 py-2 rounded-full hover:bg-brown-800 transition-colors text-sm">
                                    View Details
                                </a>
                                <a href="{{ route('contact', ['art' => $art->title]) }}" class="inline-block flex-1 text-center bg-primary-600 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition-colors text-sm">
                                    Inquire
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-12">
                        <p>No artwork available at the moment. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
