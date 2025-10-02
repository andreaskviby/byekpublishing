<div>
    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center">YouTube Videos</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">Watch Linda's latest videos</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($videos as $video)
                    <div class="bg-accent-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" rel="noopener noreferrer">
                            <div class="aspect-video bg-gray-200">
                                @if($video->thumbnail_url)
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-6xl">▶️</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-brown-900 mb-2">{{ $video->title }}</h3>
                            @if($video->description)
                                <p class="text-gray-600 mb-3 line-clamp-3">{{ Str::limit($video->description, 150) }}</p>
                            @endif
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>{{ $video->published_at->format('M d, Y') }}</span>
                                @if($video->view_count > 0)
                                    <span>{{ number_format($video->view_count) }} views</span>
                                @endif
                            </div>
                            <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-block mt-4 bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition-colors text-sm">
                                Watch on YouTube
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-12">
                        <p>No videos available yet. Subscribe to our YouTube channel to stay updated!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
