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
    @endpush

    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center">We Bought an Adventure in Sicily</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">Follow our journey as we skipped the Swedish summer house and bought a large town house in Termini Imerese, Sicily. Watch as we learn the culture, language, and make Sicilian friends in our new Mediterranean home.</p>
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
                            <h3 class="text-xl font-semibold text-brown-900 mb-2">
                                @if($video->slug)
                                    <a href="{{ route('video.detail', $video) }}" class="hover:text-primary-600 transition-colors">
                                        {{ $video->title }}
                                    </a>
                                @else
                                    {{ $video->title }}
                                @endif
                            </h3>
                            @if($video->description)
                                <p class="text-gray-600 mb-3 line-clamp-3">{{ Str::limit($video->description, 150) }}</p>
                            @endif
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>{{ $video->published_at->format('M d, Y') }}</span>
                                @if($video->view_count > 0)
                                    <span>{{ number_format($video->view_count) }} views</span>
                                @endif
                            </div>
                            <div class="flex space-x-3 mt-4">
                                @if($video->slug)
                                    <a href="{{ route('video.detail', $video) }}"
                                       class="inline-block bg-brown-900 text-white px-4 py-2 rounded-full hover:bg-brown-800 transition-colors text-sm">
                                        View Details
                                    </a>
                                @endif
                                <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-block bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition-colors text-sm">
                                    Watch on YouTube
                                </a>
                            </div>
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

    <!-- Inspiration Section -->
    <section class="py-16 bg-gradient-to-b from-accent-50 to-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-display font-bold text-brown-900 mb-6 text-center">Inspired by Husdrömmar Sicilien</h2>

            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="mb-4">
                    Our journey to <strong>Sicily</strong> and <strong>Termini Imerese</strong> was profoundly inspired by <strong>Bill and Marie Olsson Nylander</strong>, who became the first to embark on a renovation adventure in Termini Imerese. Their incredible story was featured on Swedish television in the popular SVT series <strong>Husdrömmar Sicilien</strong>, where viewers watched them transform the magnificent <strong>Palazzo Cirillo</strong>, an 18th-century palace that had stood abandoned for 30 years.
                </p>

                <p class="mb-4">
                    Watching Bill and Marie breathe new life into Palazzo Cirillo in Termini Imerese inspired us to take our own leap of faith. Like them, we traded the conventional Swedish summer house dream for something far more adventurous – a large town house in the beautiful coastal town of <strong>Termini Imerese, Sicily</strong>.
                </p>

                <p class="mb-4">
                    <strong>Termini Imerese</strong> is a charming Sicilian town with a rich history, located on the northern coast of Sicily. Once a thriving industrial center with the Fiat factory and pasta production, it has transformed into a hidden gem waiting to be rediscovered by those seeking authentic Italian life away from the tourist crowds. The town's architecture, warm community, and proximity to both the mountains and the Mediterranean Sea make it an ideal location for anyone dreaming of la dolce vita.
                </p>

                <p class="mb-4">
                    The <strong>Husdrömmar Sicilien</strong> series showed us that with determination, passion, and a willingness to embrace a new culture, it's possible to create a beautiful life in Sicily. Bill and Marie's renovation of Palazzo Cirillo demonstrated that even the most challenging projects can become rewarding adventures when approached with love and dedication.
                </p>

                <p>
                    Today, we're living our own Sicilian dream in Termini Imerese, learning Italian, navigating Italian bureaucracy, making local friends, and documenting our journey through videos and stories. While our project may be different from the grand Palazzo Cirillo, the spirit of adventure that Bill and Marie championed continues to inspire us every day. We hope our content helps others who are considering their own adventure in Sicily, whether in Termini Imerese or elsewhere on this beautiful island.
                </p>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- YouTube CTA -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Subscribe on YouTube</h3>
                    <p class="text-gray-700 mb-6">Join our growing community and never miss a Sicily adventure! Get weekly videos about life in Termini Imerese.</p>
                    <a href="https://www.youtube.com/@WeBoughtAnAdventureInSicily"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition-colors font-semibold">
                        Subscribe Now
                    </a>
                </div>

                <!-- Patreon CTA -->
                <div class="bg-gradient-to-br from-orange-50 to-pink-100 rounded-xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.386.524c-4.764 0-8.64 3.876-8.64 8.64 0 4.75 3.876 8.613 8.64 8.613 4.75 0 8.614-3.864 8.614-8.613C24 4.4 20.136.524 15.386.524M.003 23.537h4.22V.524H.003"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Support on Patreon</h3>
                    <p class="text-gray-700 mb-6">Get exclusive behind-the-scenes content, early access to videos, and help us create more Sicilian adventures!</p>
                    <a href="https://www.patreon.com/c/WeBoughtAnAdventureInSicily"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-block text-white px-8 py-3 rounded-full transition-colors font-semibold"
                       style="background-color: #F96854; hover:background-color: #E85645;">
                        Become a Patron
                    </a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 italic">
                    🦋 Join us on our Sicilian adventure and discover the magic of Termini Imerese
                </p>
            </div>
        </div>
    </section>
</div>
