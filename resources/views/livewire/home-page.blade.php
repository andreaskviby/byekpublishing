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
        
        <!-- Organization Structured Data -->
        <script type="application/ld+json">
            {!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-32 animate-gradient overflow-hidden">
        <div class="relative">
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
                               class="px-8 py-3 rounded-full hover:shadow-lg hover:-translate-y-1 transition-all duration-300 font-medium shadow-md hover:font-bold"
                               style="background-color: var(--button-bg); color: #1e293b;">
                                Explore Books
                            </a>
                            <a href="{{ route('contact') }}"
                               class="px-8 py-3 rounded-full hover:shadow-lg hover:-translate-y-1 transition-all duration-300 font-medium shadow-md hover:font-bold"
                               style="background-color: var(--button-bg); color: #1e293b;">
                                Get in Touch
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Absolute Positioned Lemons -->
            <div class="absolute -top-32 right-0 animate-slide-in-right md:opacity-100 opacity-50">
                <img src="{{ asset('images/lemons.png') }}" alt="Fresh Lemons" class="w-96 h-auto transform scale-x-[-1]">
            </div>
        </div>
    </section>

    @if($upcomingEvents->count() > 0)
    <section class="py-20 bg-gradient-to-br from-slate-50 to-accent-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-display font-bold text-brown-900 mb-6">Upcoming Events</h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Join Linda for exclusive book signings, art exhibitions, and intimate musical performances. 
                    Experience the creative journey in person and connect with fellow art enthusiasts.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($upcomingEvents as $event)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-accent-100 hover:-translate-y-2">
                        <!-- Event Date Header -->
                        <div class="p-6 relative overflow-hidden" style="background-color: var(--button-bg); color: #1e293b;">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                            <div class="relative text-center">
                                <div class="text-5xl font-black mb-2">{{ $event->event_date?->format('d') ?? 'TBD' }}</div>
                                <div class="text-lg font-semibold">{{ $event->event_date?->format('M Y') ?? 'Coming Soon' }}</div>
                            </div>
                        </div>

                        <div class="p-8">
                            <h3 class="text-2xl font-display font-bold text-brown-900 mb-4 group-hover:text-lemon-600 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <p class="text-gray-700 mb-6 leading-relaxed line-clamp-3">
                                {{ Str::limit($event->description, 150) }}
                            </p>

                            <!-- Event Details -->
                            <div class="space-y-4 text-sm text-gray-600 mb-8">
                                <div class="flex items-center p-3 bg-accent-50 rounded-lg">
                                    <div class="w-10 h-10 mr-4 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $event->start_time }}{{ $event->end_time ? ' - ' . $event->end_time : '' }}</span>
                                </div>
                                <div class="flex items-center p-3 bg-accent-50 rounded-lg">
                                    <div class="w-10 h-10 mr-4 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ Str::limit($event->street_address, 30) }}</span>
                                </div>
                                <div class="flex items-center p-3 bg-accent-50 rounded-lg">
                                    <div class="w-10 h-10 mr-4 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $event->availableSpots() }} / {{ $event->max_attendees }} spots available</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            @if($event->slug)
                                <a href="{{ route('event.slug', $event) }}"
                                   class="block w-full text-center px-8 py-4 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:font-bold"
                                   style="background-color: var(--button-bg); color: #1e293b;">
                                    View Details & RSVP
                                </a>
                            @else
                                <a href="{{ route('event.detail', $event) }}"
                                   class="block w-full text-center px-8 py-4 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:font-bold"
                                   style="background-color: var(--button-bg); color: #1e293b;">
                                    View Details & RSVP
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Section Divider - YouTube Channel -->
    <div class="relative py-12">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t-2 border-dashed" style="border-color: var(--button-bg);"></div>
        </div>
        <div class="relative flex justify-center">
            <div class="px-8 py-3 bg-white rounded-full shadow-lg border-2" style="border-color: var(--button-bg); background-color: var(--button-bg);">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="color: #1e293b;">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                    <span class="font-semibold" style="color: #1e293b;">Our YouTube Channel</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="color: #1e293b;">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- YouTube Subscriber Counter - Full Screen Wide -->
    <section class="py-16 bg-gradient-to-r from-lemon-400 via-lemon-300 to-lemon-400 w-full">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- YouTube Icon -->
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 flex items-center justify-center" style="background-color: var(--button-bg);">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Subscribers Label -->
                <div class="text-2xl font-bold text-gray-800 mb-4">YouTube Subscribers</div>
                
                <!-- Animated Counter -->
                <div class="text-6xl md:text-7xl font-black mb-4 leading-none" style="color: var(--button-bg);" wire:loading.attr="disabled">
                    <span wire:target="incrementCounter" wire:poll.2000ms="incrementCounter" class="inline-block min-w-[300px]">
                        {{ number_format($displaySubscribers) }}
                    </span>
                </div>
                
                <!-- Live Indicator -->
                <div class="flex items-center justify-center space-x-2 mb-6">
                    <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium text-gray-600">Live Counter</span>
                </div>
                
                <!-- Call to Action Message -->
                <p class="text-xl md:text-2xl font-bold text-gray-800 mb-6">
                    🎯 A lot of people follow me, why don't you too?
                </p>
                
                <!-- YouTube Subscribe Button -->
                <a href="https://www.youtube.com/@weboughtanadventureinsicily" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center px-8 py-4 rounded-full font-bold text-lg transform hover:-translate-y-1 transition-all duration-300"
                   style="background-color: var(--button-bg); color: #1e293b;">
                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                    Subscribe Now
                </a>
            </div>
        </div>
    </section>

    <!-- Section Divider -->
    <div class="relative py-12">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t-2 border-dashed" style="border-color: var(--button-bg);"></div>
        </div>
        <div class="relative flex justify-center">
            <div class="px-8 py-3 bg-white rounded-full shadow-lg border-2" style="border-color: var(--button-bg); background-color: var(--button-bg);">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: #1e293b;">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="font-semibold" style="color: #1e293b;">Featured Book</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: #1e293b;">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if($featuredBook)
    <section class="py-20 bg-gradient-to-br from-slate-50 to-accent-50" x-data="{ show: false }" x-intersect="show = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-display font-bold text-brown-900 mb-6"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    Featured Book
                </h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed"
                   x-show="show"
                   x-transition:enter="transition ease-out duration-700 delay-200"
                   x-transition:enter-start="opacity-0 transform translate-y-8"
                   x-transition:enter-end="opacity-100 transform translate-y-0">
                    Discover Linda's latest literary masterpiece - a heartfelt journey through emotions, 
                    art, and the human experience that will touch your soul and inspire your spirit.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="flex justify-center"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-700 delay-300"
                     x-transition:enter-start="opacity-0 transform -translate-x-12"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-lemon-400 to-lemon-500 rounded-2xl transform rotate-2 group-hover:rotate-3 transition-transform duration-500 opacity-20"></div>
                        <div class="relative w-80 h-auto bg-white rounded-2xl shadow-2xl overflow-hidden border border-accent-100 hover:shadow-3xl transition-all duration-500 group-hover:-translate-y-2">
                            @if($featuredBook->cover_image_url)
                                <img src="{{ $featuredBook->cover_image_url }}" alt="{{ $featuredBook->title }}" class="w-full h-auto object-contain">
                            @else
                                <div class="w-80 h-96 flex items-center justify-center bg-gradient-to-br from-lemon-100 to-accent-100">
                                    <span class="text-8xl">📖</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div x-show="show"
                     x-transition:enter="transition ease-out duration-700 delay-500"
                     x-transition:enter-start="opacity-0 transform translate-x-12"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="space-y-6">
                        <h3 class="text-4xl font-display font-bold text-brown-900 group-hover:text-lemon-600 transition-colors">
                            {{ $featuredBook->title }}
                        </h3>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            {{ $featuredBook->description }}
                        </p>
                        
                        <!-- Book Facts -->
                        <div class="space-y-4">
                            @if($featuredBook->publication_date)
                                <div class="flex items-center p-4 bg-accent-50 rounded-lg">
                                    <div class="w-10 h-10 mr-4 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Release date</div>
                                        <div class="text-sm text-gray-600">{{ $featuredBook->publication_date->format('F j, Y') }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($featuredBook->genre)
                                <div class="flex items-center p-4 bg-accent-50 rounded-lg">
                                    <div class="w-10 h-10 mr-4 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Genre</div>
                                        <div class="text-sm text-gray-600">{{ $featuredBook->genre }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('books') }}"
                           class="inline-block px-8 py-4 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:font-bold"
                           style="background-color: var(--button-bg); color: #1e293b;">
                            View All Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Section Divider -->
    <div class="relative py-12">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t-2 border-dashed" style="border-color: var(--button-bg);"></div>
        </div>
        <div class="relative flex justify-center">
            <div class="px-8 py-3 bg-white rounded-full shadow-lg border-2" style="border-color: var(--button-bg); background-color: var(--button-bg);">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: #1e293b;">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold" style="color: #1e293b;">Latest Activity</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: #1e293b;">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <section class="py-20 bg-gradient-to-br from-slate-50 to-accent-50" x-data="{ show: false }" x-intersect="show = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-display font-bold text-brown-900 mb-6"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    Latest Activity
                </h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed"
                   x-show="show"
                   x-transition:enter="transition ease-out duration-700 delay-200"
                   x-transition:enter-start="opacity-0 transform translate-y-8"
                   x-transition:enter-end="opacity-100 transform translate-y-0">
                    Follow Linda's creative journey through recent blog posts, YouTube videos, 
                    and Instagram updates. Discover behind-the-scenes content and artistic insights.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($activityFeed as $index => $item)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-accent-100 hover:-translate-y-2"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         style="transition-delay: {{ ($index % 3) * 100 }}ms;">
                        @if($item['type'] === 'blog')
                            <div class="p-8">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-500">Blog Post</span>
                                </div>
                                <h3 class="text-2xl font-display font-bold text-gray-900 mb-4 group-hover:text-lemon-600 transition-colors">{{ $item['data']->title }}</h3>
                                <p class="text-gray-700 mb-6 leading-relaxed">{{ Str::limit($item['data']->excerpt, 120) }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item['date']?->format('M d, Y') ?? 'Recent' }}
                                </div>
                            </div>
                        @elseif($item['type'] === 'youtube')
                            <div class="aspect-video bg-gray-900 relative overflow-hidden">
                                @if($item['data']->thumbnail_url)
                                    <img src="{{ $item['data']->thumbnail_url }}" alt="{{ $item['data']->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800">
                                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg bg-red-600 text-white">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-500">YouTube Video</span>
                                </div>
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-3 group-hover:text-lemon-600 transition-colors">{{ $item['data']->title }}</h3>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item['date']?->format('M d, Y') ?? 'Recent' }}
                                </div>
                            </div>
                        @elseif($item['type'] === 'instagram')
                            <div class="aspect-square bg-gradient-to-br from-purple-400 via-pink-500 to-orange-400 relative overflow-hidden">
                                @if($item['data']->media_url)
                                    <img src="{{ $item['data']->media_url }}" alt="Instagram post" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                                <div class="absolute top-3 right-3">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 text-white">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-500">Instagram Post</span>
                                </div>
                                <p class="text-gray-700 mb-4 leading-relaxed">{{ Str::limit($item['data']->caption, 100) }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item['date']?->format('M d, Y') ?? 'Recent' }}
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16">
                        <div class="w-20 h-20 mx-auto mb-6 bg-accent-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-semibold text-gray-900 mb-3">No Activity Yet</h3>
                        <p class="text-gray-600 max-w-md mx-auto">Check back soon for the latest blog posts, videos, and social media updates from Linda!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section Divider -->
    <div class="relative py-12">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t-2 border-dashed" style="border-color: var(--button-bg);"></div>
        </div>
        <div class="relative flex justify-center">
            <div class="px-8 py-3 bg-white rounded-full shadow-lg border-2" style="border-color: var(--button-bg); background-color: var(--button-bg);">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: #1e293b;">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold" style="color: #1e293b;">Art Gallery Preview</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: #1e293b;">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if($artPieces->count() > 0)
    <section class="py-20 bg-gradient-to-br from-slate-50 to-accent-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-display font-bold text-brown-900 mb-6">Art Gallery Preview</h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Explore Linda's stunning collection of original artworks. Each piece tells a unique story 
                    through vibrant colors, emotional depth, and creative expression that speaks to the soul.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($artPieces as $art)
                    <div class="group">
                        @if($art->slug)
                            <a href="{{ route('art.detail', $art) }}" class="block bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-accent-100 hover:-translate-y-2">
                        @else
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-accent-100">
                        @endif
                            <div class="aspect-square bg-gradient-to-br from-lemon-100 to-accent-100 relative overflow-hidden">
                                @if($art->image_url)
                                    <img src="{{ $art->image_url }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-8xl">🎨</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-500">Original Artwork</span>
                                </div>
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-3 group-hover:text-lemon-600 transition-colors">{{ $art->title }}</h3>
                                @if($art->price)
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-semibold" style="color: var(--button-bg);">{{ number_format($art->price, 0) }} {{ $art->currency }}</p>
                                        <span class="text-xs bg-accent-100 text-accent-700 px-3 py-1 rounded-full font-medium">Available</span>
                                    </div>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">Price on Request</span>
                                @endif
                            </div>
                        @if($art->slug)
                            </a>
                        @else
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('art') }}"
                   class="inline-block px-8 py-4 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:font-bold"
                   style="background-color: var(--button-bg); color: #1e293b;">
                    View Full Gallery
                </a>
            </div>
        </div>
    </section>
    @else
    <section class="py-20 bg-gradient-to-br from-slate-50 to-accent-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-display font-bold text-brown-900 mb-6">Art Gallery Preview</h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Explore Linda's stunning collection of original artworks. Each piece tells a unique story 
                    through vibrant colors, emotional depth, and creative expression that speaks to the soul.
                </p>
            </div>
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-8 bg-accent-100 rounded-full flex items-center justify-center">
                    <span class="text-6xl">🎨</span>
                </div>
                <h3 class="text-2xl font-display font-semibold text-gray-900 mb-4">Art Coming Soon</h3>
                <p class="text-gray-600 max-w-md mx-auto text-lg">
                    Linda is currently creating new masterpieces. Check back soon to explore her latest 
                    collection of original artworks and creative expressions.
                </p>
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
                            @if($music->album_cover_url)
                                <img src="{{ $music->album_cover_url }}" alt="{{ $music->title }}" class="w-full h-full object-cover">
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
