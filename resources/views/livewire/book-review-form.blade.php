<div class="bg-gradient-to-br from-orange-50 to-pink-50 rounded-2xl p-8 shadow-lg">
    <div class="text-center mb-8">
        <h3 class="text-2xl font-display font-bold text-brown-900 mb-2">Share Your Thoughts</h3>
        <p class="text-gray-600">Help others discover this book by sharing your experience</p>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit="submitReview">
        <!-- Honeypot field (hidden) -->
        <input type="text" wire:model="website" style="display: none;" tabindex="-1" autocomplete="off">

        <!-- Butterfly Rating System -->
        <div class="mb-8">
            <label class="block text-lg font-semibold text-brown-900 mb-4 text-center">
                How did you like this book?
            </label>
            <div class="flex justify-center space-x-2 mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button"
                            wire:click="$set('rating', {{ $i }})"
                            class="text-4xl transition-all duration-200 hover:scale-110 focus:outline-none focus:scale-110"
                            style="{{ $rating >= $i ? '' : 'filter: grayscale(100%); opacity: 0.4;' }}"
                            title="{{ $i }} {{ $i === 1 ? 'butterfly' : 'butterflies' }}">
                        🦋
                    </button>
                @endfor
            </div>
            <div class="text-center text-sm text-gray-600">
                @if ($rating === 0)
                    <span>Click the butterflies to rate</span>
                @elseif ($rating === 1)
                    <span class="text-red-600">Not impressed</span>
                @elseif ($rating === 2)
                    <span class="text-orange-600">It was okay</span>
                @elseif ($rating === 3)
                    <span class="text-yellow-600">Good read</span>
                @elseif ($rating === 4)
                    <span class="text-blue-600">Really enjoyed it</span>
                @else
                    <span class="text-purple-600">Absolutely loved it!</span>
                @endif
            </div>
            @error('rating')
                <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>

        <!-- Optional Review Text -->
        <div class="mb-6">
            <label for="reviewText" class="block text-base font-semibold text-brown-900 mb-3">
                Your Review <span class="text-gray-500 font-normal">(Optional)</span>
            </label>
            <textarea id="reviewText"
                     wire:model="reviewText"
                     rows="4"
                     class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                            focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                            transition-all duration-300 hover:border-primary-300
                            bg-white placeholder-gray-400 resize-none"
                     placeholder="Share your thoughts about this book... What did you love? What could be better? Would you recommend it?"></textarea>
            @error('reviewText')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-gray-500">{{ strlen($reviewText) }}/1000 characters</p>
        </div>

        <!-- Optional Signature -->
        <div class="mb-6">
            <label for="signature" class="block text-base font-semibold text-brown-900 mb-3">
                Your Name <span class="text-gray-500 font-normal">(Optional)</span>
            </label>
            <input type="text"
                   id="signature"
                   wire:model="signature"
                   class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                          focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                          transition-all duration-300 hover:border-primary-300
                          bg-white placeholder-gray-400"
                   placeholder="How would you like to be known? (e.g., Book Lover, Sarah K., etc.)">
            @error('signature')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Newsletter Signup -->
        <div class="mb-6 p-4 bg-white rounded-xl shadow-sm">
            <div class="flex items-start space-x-3">
                <input type="checkbox"
                       id="subscribeToNewsletter"
                       wire:model.live="subscribeToNewsletter"
                       class="mt-0.5 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <div class="flex-1">
                    <label for="subscribeToNewsletter" class="text-sm font-semibold text-brown-900 cursor-pointer">
                        📧 Join Linda's Creative Newsletter
                    </label>
                </div>
            </div>

            <!-- Newsletter fields with smooth animation -->
            <div class="overflow-hidden transition-all duration-500 ease-in-out {{ $showNewsletterFields ? 'max-h-80 opacity-100 mt-4' : 'max-h-0 opacity-0' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                            Your Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               wire:model="name"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg shadow-sm
                                      focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                      transition-all duration-300"
                               placeholder="Your full name">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               wire:model="email"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg shadow-sm
                                      focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                      transition-all duration-300"
                               placeholder="your@email.com">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 p-2 bg-blue-50 rounded-lg shadow-sm">
                    <div class="flex items-start text-xs text-blue-800">
                        <svg class="w-3 h-3 mr-1.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>We'll send you a verification email to confirm your subscription.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-8 py-4 font-semibold rounded-xl shadow-lg hover:shadow-xl
                           transform hover:scale-105 transition-all duration-300
                           focus:outline-none focus:ring-2 focus:ring-lemon-400 focus:ring-offset-2
                           disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none hover:font-bold"
                    style="background-color: var(--button-bg); color: #1e293b;">
                <span wire:loading.remove>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Share Your Review
                </span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Submitting...
                </span>
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-500">
            <p>Your review will be published after verification and approval.</p>
        </div>
    </form>
</div>
