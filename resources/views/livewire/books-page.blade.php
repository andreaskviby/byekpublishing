<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center">Books</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">Explore emotional journeys through powerful storytelling</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <label for="language-filter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Language:</label>
                <select wire:model.live="selectedLanguageId" id="language-filter" class="border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Languages</option>
                    @foreach($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->flag_emoji }} {{ $language->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-12">
                @forelse($books as $book)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-accent-100 rounded-lg p-8">
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
                            <div class="w-64 h-96 bg-gradient-to-br from-primary-200 to-accent-200 rounded-lg shadow-xl flex items-center justify-center">
                                @if($coverImageUrl)
                                    <img src="{{ $coverImageUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <span class="text-6xl">📖</span>
                                @endif
                            </div>
                            @if($book->sample_pdf_url)
                                <a href="{{ $book->sample_pdf_url }}" target="_blank" rel="noopener noreferrer"
                                   class="mt-4 inline-flex items-center text-sm text-primary-600 hover:text-primary-700 hover:underline transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Read a sample
                                </a>
                            @endif
                        </div>

                        <div class="md:col-span-2 relative">
                            @if($book->isSoonToBeReleased())
                                <div class="mb-4">
                                    <span class="inline-block bg-[#F2D837] text-brown-900 px-6 py-2 rounded-full text-sm font-bold uppercase tracking-wide">
                                        🎄 Snart Tillgänglig - Förbeställ nu!
                                    </span>
                                </div>
                            @elseif($book->status === 'out_of_stock')
                                <div class="mb-4">
                                    <span class="inline-block bg-red-100 text-red-800 px-6 py-2 rounded-full text-sm font-bold uppercase tracking-wide">
                                        Slutsåld
                                    </span>
                                </div>
                            @endif

                            <h2 class="text-3xl font-display font-bold text-brown-900 mb-4">
                                @if($book->slug)
                                    <a href="{{ route('book.detail', $book) }}" class="hover:text-primary-600 hover:underline transition-all">
                                        {{ $book->title }}
                                    </a>
                                @else
                                    {{ $book->title }}
                                @endif
                            </h2>
                            <p class="text-gray-700 mb-6">{{ $book->description }}</p>

                            @if($book->isbn)
                                <p class="text-sm text-gray-600 mb-2"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            @endif
                            @if($book->pages)
                                <p class="text-sm text-gray-600 mb-2"><strong>Pages:</strong> {{ $book->pages }}</p>
                            @endif
                            @if($book->genre)
                                <p class="text-sm text-gray-600 mb-6"><strong>Genre:</strong> {{ $book->genre }}</p>
                            @endif

                            <div class="mt-6">
                                @if($book->isSoonToBeReleased())
                                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 border-2 border-[#F2D837] rounded-lg p-6">
                                        <h3 class="text-lg font-semibold text-brown-900 mb-3">Förbeställ nu!</h3>
                                        <p class="text-sm text-brown-700 mb-4">
                                            Säkra ditt exemplar redan idag. Boken skickas hem till dig så snart den är tillgänglig.
                                            Perfekt som julklapp! 🎁
                                        </p>
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('book.preorder', $book) }}"
                                               class="inline-block bg-[#F2D837] text-brown-900 px-6 py-3 rounded-xl hover:bg-[#dac430] transition-colors font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                Förbeställ för 199 SEK
                                            </a>
                                        </div>
                                    </div>
                                @elseif($book->allow_christmas_orders)
                                    <div class="bg-gradient-to-br from-red-50 via-green-50 to-yellow-50 border-2 border-[#F2D837] rounded-lg p-6 mb-4">
                                        <h3 class="text-lg font-semibold text-brown-900 mb-3 flex items-center">
                                            🎄 Beställ med jul-inpackning och signering!
                                        </h3>
                                        <p class="text-sm text-brown-700 mb-4">
                                            Köp boken med vacker julklappsinpackning (+45 SEK) och be om en personlig dedikation från Linda.
                                            Perfekt julklapp! 🎁
                                        </p>
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ route('book.preorder', $book) }}"
                                               class="inline-block bg-[#F2D837] text-brown-900 px-6 py-3 rounded-xl hover:bg-[#dac430] transition-colors font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                Beställ för 199 SEK
                                            </a>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Eller köp här:</h3>
                                    <div class="space-y-4">
                                        @foreach($book->purchaseLinks->groupBy('language_id') as $languageId => $links)
                                            @php $language = $links->first()->language; @endphp
                                            <div class="bg-white rounded-lg p-4">
                                                <h4 class="font-medium text-brown-900 mb-3">{{ $language->flag_emoji }} {{ $language->name }}</h4>
                                                <div class="flex flex-wrap gap-3">
                                                    @foreach($links->where('is_active', true) as $link)
                                                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                                           class="inline-block bg-primary-600 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition-colors text-sm">
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
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Available in:</h3>
                                    <div class="space-y-4">
                                        @foreach($book->purchaseLinks->groupBy('language_id') as $languageId => $links)
                                            @php $language = $links->first()->language; @endphp
                                            <div class="bg-white rounded-lg p-4">
                                                <h4 class="font-medium text-brown-900 mb-3">{{ $language->flag_emoji }} {{ $language->name }}</h4>
                                                <div class="flex flex-wrap gap-3">
                                                    @foreach($links->where('is_active', true) as $link)
                                                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                                           class="inline-block bg-primary-600 text-white px-4 py-2 rounded-full hover:bg-primary-700 transition-colors text-sm">
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
                                <div class="mt-6 text-right">
                                    <a href="{{ route('book.detail', $book) }}"
                                       class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700 hover:underline transition-colors">
                                        Learn More
                                        <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-12">
                        <p>No books available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
