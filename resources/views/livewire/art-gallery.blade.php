<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <section class="bg-gradient-to-br from-slate-50 to-accent-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-display font-bold text-brown-900 mb-6">Art Gallery</h1>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed">Original artwork available for inquiry and purchase. Each piece tells a unique story through vibrant colors and emotional expression.</p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($artPieces as $art)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-accent-100 hover:-translate-y-2">
                        @if($art->slug)
                            <a href="{{ route('art.detail', $art) }}" class="block aspect-square bg-gradient-to-br from-lemon-100 to-accent-100 relative overflow-hidden">
                        @else
                            <div class="block aspect-square bg-gradient-to-br from-lemon-100 to-accent-100 relative overflow-hidden">
                        @endif
                            @if($art->image_url)
                                <img src="{{ $art->image_url }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-8xl">🎨</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @if($art->slug)
                            </a>
                        @else
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <div class="w-8 h-8 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Original Artwork</span>
                            </div>
                            @if($art->slug)
                                <a href="{{ route('art.detail', $art) }}" class="block group-hover:text-lemon-600 transition-colors">
                            @else
                                <div class="block">
                            @endif
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-3">{{ $art->title }}</h3>
                            @if($art->slug)
                                </a>
                            @else
                                </div>
                            @endif
                            @if($art->description)
                                <p class="text-gray-700 mb-4 leading-relaxed">{{ Str::limit($art->description, 120) }}</p>
                            @endif
                            <div class="space-y-2 mb-4">
                                @if($art->medium)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-6 h-6 mr-2 flex-shrink-0 flex items-center justify-center rounded" style="background-color: var(--button-bg); color: #1e293b;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                            </svg>
                                        </div>
                                        <span><strong>Medium:</strong> {{ $art->medium }}</span>
                                    </div>
                                @endif
                                @if($art->dimensions)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-6 h-6 mr-2 flex-shrink-0 flex items-center justify-center rounded" style="background-color: var(--button-bg); color: #1e293b;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                            </svg>
                                        </div>
                                        <span><strong>Dimensions:</strong> {{ $art->dimensions }}</span>
                                    </div>
                                @endif
                                @if($art->year)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <div class="w-6 h-6 mr-2 flex-shrink-0 flex items-center justify-center rounded" style="background-color: var(--button-bg); color: #1e293b;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span><strong>Year:</strong> {{ $art->year }}</span>
                                    </div>
                                @endif
                            </div>
                            @if($art->price)
                                <p class="text-xl font-semibold mb-4" style="color: var(--button-bg);">{{ number_format($art->price, 0) }} {{ $art->currency }}</p>
                            @endif
                            <div class="flex gap-3">
                                @if($art->slug)
                                    <a href="{{ route('art.detail', $art) }}" class="inline-block flex-1 text-center px-4 py-3 rounded-xl transition-all duration-300 font-medium shadow-md hover:shadow-lg hover:-translate-y-1 hover:font-bold border-2 border-accent-200 hover:border-lemon-400" style="color: var(--button-bg);">
                                        View Details
                                    </a>
                                @else
                                    <div class="inline-block flex-1 text-center px-4 py-3 rounded-xl border-2 border-accent-200" style="color: var(--button-bg);">
                                        View Details
                                    </div>
                                @endif
                                <a href="{{ route('contact', ['art' => $art->title]) }}" class="inline-block flex-1 text-center px-4 py-3 rounded-xl transition-all duration-300 font-medium shadow-md hover:shadow-lg hover:-translate-y-1 hover:font-bold" style="background-color: var(--button-bg); color: #1e293b;">
                                    Inquire
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20">
                        <div class="w-24 h-24 mx-auto mb-8 bg-accent-100 rounded-full flex items-center justify-center">
                            <span class="text-6xl">🎨</span>
                        </div>
                        <h3 class="text-2xl font-display font-semibold text-gray-900 mb-4">No Artwork Available</h3>
                        <p class="text-gray-600 max-w-md mx-auto text-lg">Check back soon for new original artworks and creative expressions from Linda!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
