<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center">Music Releases</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">AI-assisted experimental music by By Ek Publishing</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($musicReleases as $music)
                    <div class="bg-accent-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <div class="aspect-square bg-gradient-to-br from-primary-300 to-accent-300 flex items-center justify-center">
                            @if($music->album_cover_url)
                                <img src="{{ $music->album_cover_url }}" alt="{{ $music->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-6xl">🎵</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-brown-900 mb-2">{{ $music->title }}</h3>
                            <p class="text-gray-600 mb-3">{{ $music->artist_name }}</p>
                            <p class="text-sm text-gray-500 mb-4">Released: {{ $music->release_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500 mb-4 uppercase">{{ $music->release_type }}</p>

                            <div class="flex flex-wrap gap-2">
                                @if($music->spotify_url)
                                    <a href="{{ $music->spotify_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-block bg-green-600 text-white px-3 py-2 rounded-full hover:bg-green-700 transition-colors text-sm">
                                        Spotify
                                    </a>
                                @endif
                                @if($music->apple_music_url)
                                    <a href="{{ $music->apple_music_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-block bg-primary-600 text-white px-3 py-2 rounded-full hover:bg-primary-700 transition-colors text-sm">
                                        Apple Music
                                    </a>
                                @endif
                                @if($music->youtube_music_url)
                                    <a href="{{ $music->youtube_music_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-block bg-red-600 text-white px-3 py-2 rounded-full hover:bg-red-700 transition-colors text-sm">
                                        YouTube Music
                                    </a>
                                @endif
                                @if($music->distrokid_url)
                                    <a href="{{ $music->distrokid_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-block bg-blue-600 text-white px-3 py-2 rounded-full hover:bg-blue-700 transition-colors text-sm">
                                        More Platforms
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-12">
                        <p>No music releases available yet. Stay tuned!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
