<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <section class="bg-gradient-to-br from-slate-50 to-accent-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-display font-bold text-brown-900 mb-6">Books</h1>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed">Explore emotional journeys through powerful storytelling that touches the heart and inspires the soul.</p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <label for="language-filter" class="block text-sm font-semibold text-gray-700 mb-3">Filter by Language:</label>
                <select wire:model.live="selectedLanguageId" id="language-filter" class="border-2 border-accent-200 rounded-lg shadow-sm focus:ring-2 focus:ring-lemon-400 focus:border-lemon-400 px-4 py-2">
                    <option value="">All Languages</option>
                    @foreach($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->flag_emoji }} {{ $language->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-16">
                @forelse($books as $book)
                    <div class="group">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 bg-gradient-to-br from-slate-50 to-accent-50 rounded-2xl p-10 shadow-lg hover:shadow-xl transition-all duration-500">
                            <div class="flex flex-col items-center justify-center">
                                @php
                                    $coverImageUrl = $book->cover_image_url;
                                    // If filtered by language, try to show language-specific cover
                                    if ($selectedLanguageId && $coverImageUrl) {
                                        $language = $languages->firstWhere('id', $selectedLanguageId);
                                        if ($language) {
                                            $langCoverUrl = str_replace('.jpg', '-' . $language->code . '.jpg', $coverImageUrl);
                                            $langCoverUrl = str_replace('.png', '-' . $language->code . '.png', $langCoverUrl);
                                            // Check if language-specific file exists
                                            $publicPath = str_replace('/storage/', '', $langCoverUrl);
                                            if (str_starts_with($langCoverUrl, '/images/') && file_exists(public_path($langCoverUrl))) {
                                                $coverImageUrl = $langCoverUrl;
                                            }
                                        }
                                    }
                                @endphp
                                <div class="group relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-lemon-400 to-lemon-500 rounded-2xl transform rotate-2 group-hover:rotate-3 transition-transform duration-500 opacity-20"></div>
                                    <div class="relative w-80 h-96 bg-white rounded-2xl shadow-2xl overflow-hidden border border-accent-100 hover:shadow-3xl transition-all duration-500 group-hover:-translate-y-2">
                                        @if($coverImageUrl)
                                            <img src="{{ $coverImageUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-lemon-100 to-accent-100">
                                                <span class="text-8xl">📖</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if($book->sample_pdf_url)
                                    <a href="{{ $book->sample_pdf_url }}" target="_blank" rel="noopener noreferrer"
                                       class="mt-6 inline-flex items-center px-6 py-3 rounded-xl border-2 border-accent-200 hover:border-lemon-400 transition-all duration-300 font-medium"
                                       style="color: var(--button-bg);">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Read a sample
                                    </a>
                                @endif
                            </div>

                            <div class="md:col-span-2 relative">
                                @if($book->isSoonToBeReleased())
                                    <div class="mb-6">
                                        <span class="inline-block px-8 py-3 rounded-full text-sm font-bold uppercase tracking-wide shadow-lg"
                                              style="background-color: var(--button-bg); color: #1e293b;">
                                            🎄 Snart Tillgänglig - Förbeställ nu!
                                        </span>
                                    </div>
                                @elseif($book->status === 'out_of_stock')
                                    <div class="mb-6">
                                        <span class="inline-block bg-red-100 text-red-800 px-8 py-3 rounded-full text-sm font-bold uppercase tracking-wide shadow-lg">
                                            Slutsåld
                                        </span>
                                    </div>
                                @endif

                                <h2 class="text-4xl font-display font-bold text-brown-900 mb-6 group-hover:text-lemon-600 transition-colors">
                                    @if($book->slug)
                                        <a href="{{ route('book.detail', $book) }}" class="hover:underline transition-all">
                                            {{ $book->title }}
                                        </a>
                                    @else
                                        {{ $book->title }}
                                    @endif
                                </h2>
                                <p class="text-lg text-gray-700 mb-8 leading-relaxed">{{ $book->description }}</p>

                                <!-- Book Details -->
                                <div class="space-y-3 mb-8">
                                    @if($book->isbn)
                                        <div class="flex items-center p-3 bg-accent-50 rounded-lg">
                                            <div class="w-8 h-8 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">ISBN</div>
                                                <div class="text-sm text-gray-600">{{ $book->isbn }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($book->pages)
                                        <div class="flex items-center p-3 bg-accent-50 rounded-lg">
                                            <div class="w-8 h-8 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Pages</div>
                                                <div class="text-sm text-gray-600">{{ $book->pages }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($book->genre)
                                        <div class="flex items-center p-3 bg-accent-50 rounded-lg">
                                            <div class="w-8 h-8 mr-3 flex-shrink-0 flex items-center justify-center rounded-lg" style="background-color: var(--button-bg); color: #1e293b;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Genre</div>
                                                <div class="text-sm text-gray-600">{{ $book->genre }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-8">
                                    @if($book->isSoonToBeReleased())
                                        <div class="bg-gradient-to-br from-lemon-50 to-amber-50 border-2 rounded-xl p-8"
                                             style="border-color: var(--button-bg);">
                                            <h3 class="text-xl font-semibold text-brown-900 mb-4">Förbeställ nu!</h3>
                                            <p class="text-base text-brown-700 mb-6 leading-relaxed">
                                                Säkra ditt exemplar redan idag. Boken skickas hem till dig så snart den är tillgänglig.
                                                Perfekt som julklapp! 🎁
                                            </p>
                                            <div class="flex flex-wrap gap-4">
                                                <a href="{{ route('book.preorder', $book) }}"
                                                   class="inline-block px-8 py-4 rounded-xl transition-all duration-300 font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:font-bold"
                                                   style="background-color: var(--button-bg); color: #1e293b;">
                                                    Förbeställ för 199 SEK
                                                </a>
                                            </div>
                                        </div>
                                    @elseif($book->allow_christmas_orders)
                                        <div class="relative bg-gradient-to-br from-red-600 via-red-700 to-red-800 border-2 rounded-xl p-8 mb-6 shadow-2xl"
                                             style="border-color: #FFD700;">
                                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-yellow-600/20 rounded-xl"></div>
                                            <div class="relative">
                                                <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                                                    🎄 Beställ med jul-inpackning och signering!
                                                </h3>
                                                <p class="text-base text-white/90 mb-6 leading-relaxed">
                                                    Köp boken med vacker julklappsinpackning (+45 SEK) och be om en personlig dedikation från Linda.
                                                    Perfekt julklapp! 🎁
                                                </p>
                                                <div class="flex flex-wrap gap-4">
                                                    <a href="{{ route('book.preorder', $book) }}"
                                                       class="inline-block px-8 py-4 rounded-xl transition-all duration-300 font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:font-bold bg-white text-red-700 hover:bg-yellow-100 border-2 border-yellow-400">
                                                        🎅 Beställ för 199 SEK
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Eller köp här:</h3>
                                        <div class="space-y-6">
                                            @foreach($book->purchaseLinks->groupBy('language_id') as $languageId => $links)
                                                @php $language = $links->first()->language; @endphp
                                                <div class="bg-white rounded-xl p-6 shadow-lg border border-accent-100">
                                                    <h4 class="font-semibold text-brown-900 mb-4 text-lg">{{ $language->flag_emoji }} {{ $language->name }}</h4>
                                                    <div class="flex flex-wrap gap-3">
                                                        @foreach($links->where('is_active', true) as $link)
                                                            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                                               class="inline-block px-6 py-3 rounded-xl transition-all duration-300 font-medium shadow-md hover:shadow-lg hover:-translate-y-1 hover:font-bold"
                                                               style="background-color: var(--button-bg); color: #1e293b;">
                                                                {{ $link->store_name }}
                                                                @if($link->format)
                                                                    ({{ $link->format }})
                                                                @endif
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Available in:</h3>
                                        <div class="space-y-6">
                                            @foreach($book->purchaseLinks->groupBy('language_id') as $languageId => $links)
                                                @php $language = $links->first()->language; @endphp
                                                <div class="bg-white rounded-xl p-6 shadow-lg border border-accent-100">
                                                    <h4 class="font-semibold text-brown-900 mb-4 text-lg">{{ $language->flag_emoji }} {{ $language->name }}</h4>
                                                    <div class="flex flex-wrap gap-3">
                                                        @foreach($links->where('is_active', true) as $link)
                                                            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                                               class="inline-block px-6 py-3 rounded-xl transition-all duration-300 font-medium shadow-md hover:shadow-lg hover:-translate-y-1 hover:font-bold"
                                                               style="background-color: var(--button-bg); color: #1e293b;">
                                                                {{ $link->store_name }}
                                                                @if($link->format)
                                                                    ({{ $link->format }})
                                                                @endif
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                @if($book->slug)
                                    <div class="mt-8 text-right">
                                        <a href="{{ route('book.detail', $book) }}"
                                           class="inline-flex items-center px-6 py-3 rounded-xl border-2 border-accent-200 hover:border-lemon-400 transition-all duration-300 font-semibold"
                                           style="color: var(--button-bg);">
                                            Learn More
                                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto mb-8 bg-accent-100 rounded-full flex items-center justify-center">
                            <span class="text-6xl">📚</span>
                        </div>
                        <h3 class="text-2xl font-display font-semibold text-gray-900 mb-4">No Books Available</h3>
                        <p class="text-gray-600 max-w-md mx-auto text-lg">Check back soon for new releases and literary adventures from Linda!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
