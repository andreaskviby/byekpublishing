<div class="bg-white">
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-50 via-yellow-50 to-accent-100 py-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-6">
                <h1 class="text-5xl md:text-6xl font-display font-bold mb-4 leading-tight text-stone-900">
                    {{ $book->title }}
                </h1>
                <div class="inline-block bg-[#F2D837] px-8 py-3 rounded-full">
                    <p class="text-lg md:text-xl font-bold text-brown-900 uppercase tracking-wide">Bestall med jul-inpackning!</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-2xl font-display font-bold mb-2 text-stone-900">
                    Perfekt som julklapp!
                </p>
                <p class="text-lg text-brown-700">Signerad, julklappsinslagen och hemskickad till dig</p>
            </div>
        </div>
    </section>

    <!-- Book Details and Order Form -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Book Details -->
                <div>
                    <!-- Book Cover and Info -->
                    <div class="bg-white p-8 rounded-3xl shadow-xl mb-8 border-2 border-gray-200">
                        <div class="flex flex-col md:flex-row gap-6">
                            @if($book->cover_image_url)
                                <div class="flex-shrink-0">
                                    <img src="{{ $book->cover_image_url }}"
                                         alt="{{ $book->title }}"
                                         class="w-48 h-auto rounded-xl shadow-2xl mx-auto">
                                </div>
                            @endif
                            <div class="flex-1">
                                <h2 class="text-3xl font-display font-bold text-brown-900 mb-4">{{ $book->title }}</h2>

                                @if($book->isbn)
                                    <div class="mb-3">
                                        <span class="text-sm font-semibold text-brown-700 uppercase tracking-wide">ISBN</span>
                                        <p class="text-lg text-brown-900">{{ $book->isbn }}</p>
                                    </div>
                                @endif

                                @if($book->pages)
                                    <div class="mb-3">
                                        <span class="text-sm font-semibold text-brown-700 uppercase tracking-wide">Antal sidor</span>
                                        <p class="text-lg text-brown-900">{{ $book->pages }} sidor</p>
                                    </div>
                                @endif

                                @if($book->genre)
                                    <div class="mb-3">
                                        <span class="text-sm font-semibold text-brown-700 uppercase tracking-wide">Genre</span>
                                        <p class="text-lg text-brown-900">{{ $book->genre }}</p>
                                    </div>
                                @endif

                                @if($book->publication_date)
                                    <div class="mb-3">
                                        <span class="text-sm font-semibold text-brown-700 uppercase tracking-wide">Utgivningsdatum</span>
                                        <p class="text-lg text-brown-900">{{ $book->publication_date->locale('sv')->isoFormat('MMMM YYYY') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Price and Benefits -->
                    <div class="bg-white p-8 rounded-3xl shadow-xl mb-8 border-2 border-gray-200">
                        <h2 class="text-3xl font-display font-bold text-brown-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 mr-3 text-[#dac430]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pris & Leverans
                        </h2>

                        <div class="space-y-6">
                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-[#F2D837] rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Bokpris</div>
                                    <div class="text-2xl font-bold text-brown-900">{{ $book->price }} SEK</div>
                                    <div class="text-sm text-gray-600">Fri frakt ingar!</div>
                                </div>
                            </div>

                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-[#F2D837] rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Julklappsinpackning</div>
                                    <div class="text-lg font-bold text-brown-900">+49 SEK</div>
                                    <div class="text-sm text-gray-600">Vackert inslaget i julpapper med etikett</div>
                                </div>
                            </div>

                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-[#F2D837] rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Signerad dedikation</div>
                                    <div class="text-lg font-bold text-brown-900">Ingar!</div>
                                    <div class="text-sm text-gray-600">Be om en personlig halsning fran forfattaren</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                        <div class="bg-white p-8 rounded-3xl shadow-lg border-2 border-gray-200">
                            <h3 class="text-2xl font-display font-bold text-brown-900 mb-4 flex items-center">
                                <svg class="w-7 h-7 mr-3 text-[#dac430]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Om boken
                            </h3>
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $book->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Order Form -->
                <div class="lg:sticky lg:top-8 h-fit">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border-2 border-gray-200">
                        <div class="text-center mb-6">
                            <h3 class="text-3xl font-display font-bold text-brown-900 mb-2">Bestall nu</h3>
                            <p class="text-gray-600">Bestall din bok med julklappsinpackning</p>
                        </div>

                        <livewire:book-order-form :book="$book" />
                    </div>

                    <!-- Payment Info Box -->
                    <div class="mt-6 bg-gradient-to-br from-yellow-50 to-amber-50 p-6 rounded-2xl border-2 border-[#F2D837]">
                        <h4 class="font-bold text-brown-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#dac430]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sa fungerar det:
                        </h4>
                        <ol class="space-y-2 text-sm text-brown-800">
                            <li class="flex items-start">
                                <span class="font-bold mr-2 text-[#dac430]">1.</span>
                                <span>Fyll i formularet och valj dina alternativ</span>
                            </li>
                            <li class="flex items-start">
                                <span class="font-bold mr-2 text-[#dac430]">2.</span>
                                <span>Du far en bekraftelse via e-post med Swish-betalningsinstruktioner</span>
                            </li>
                            <li class="flex items-start">
                                <span class="font-bold mr-2 text-[#dac430]">3.</span>
                                <span>Betala inom 2 timmar for att sakra din bestallning</span>
                            </li>
                            <li class="flex items-start">
                                <span class="font-bold mr-2 text-[#dac430]">4.</span>
                                <span>Boken skickas hem till dig inom nagra dagar!</span>
                            </li>
                        </ol>
                    </div>

                    <!-- Social reminder -->
                    <a href="https://instagram.com/lindaettehagkviby" target="_blank" class="mt-6 bg-white text-black p-6 rounded-2xl text-center shadow-lg border-2 border-gray-200 block hover:shadow-xl transition-shadow duration-300">
                        <p class="text-lg font-semibold mb-2">Folj mig pa Instagram</p>
                        <p class="text-brown-900 font-bold text-xl">@lindaettehagkviby</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
