<div>
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
                        <div class="flex justify-center">
                            @php
                                $coverImage = $book->cover_image;
                                // If filtered by language, try to show language-specific cover
                                if ($selectedLanguageId) {
                                    $language = $languages->firstWhere('id', $selectedLanguageId);
                                    if ($language && $book->cover_image) {
                                        $langCover = str_replace('.jpg', '-' . $language->code . '.jpg', $book->cover_image);
                                        $langCover = str_replace('.png', '-' . $language->code . '.png', $langCover);
                                        if (file_exists(public_path($langCover))) {
                                            $coverImage = $langCover;
                                        }
                                    }
                                }
                            @endphp
                            <div class="w-64 h-96 bg-gradient-to-br from-primary-200 to-accent-200 rounded-lg shadow-xl flex items-center justify-center">
                                @if($coverImage)
                                    <img src="{{ $coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <span class="text-6xl">📖</span>
                                @endif
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <h2 class="text-3xl font-display font-bold text-brown-900 mb-4">{{ $book->title }}</h2>
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
                            </div>
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
