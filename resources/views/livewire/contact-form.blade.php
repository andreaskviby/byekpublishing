<div>
    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16 animate-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center animate-fadeInUp">Contact Linda</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">Have questions about art or want to get in touch?</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-8 shadow-md animate-fadeInUp" role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="font-medium">{{ session('message') }}</p>
                    </div>
                </div>
            @endif

            <form wire:submit="submit" class="space-y-8 bg-accent-50 p-8 rounded-2xl shadow-lg">
                <div class="animate-fadeInUp" style="animation-delay: 0.1s">
                    <label for="name" class="block text-base font-semibold text-brown-900 mb-3">
                        Name <span class="text-primary-600">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           wire:model="name"
                           class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="Your full name"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="animate-fadeInUp" style="animation-delay: 0.2s">
                    <label for="email" class="block text-base font-semibold text-brown-900 mb-3">
                        Email <span class="text-primary-600">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           wire:model="email"
                           class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="your.email@example.com"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="animate-fadeInUp" style="animation-delay: 0.3s">
                    <label for="subject" class="block text-base font-semibold text-brown-900 mb-3">
                        Subject <span class="text-primary-600">*</span>
                    </label>
                    <input type="text"
                           id="subject"
                           wire:model="subject"
                           class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="What would you like to discuss?"
                           required>
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="animate-fadeInUp" style="animation-delay: 0.4s">
                    <label for="message" class="block text-base font-semibold text-brown-900 mb-3">
                        Message <span class="text-primary-600">*</span>
                    </label>
                    <textarea id="message"
                              wire:model="message"
                              rows="7"
                              class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                     focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                     transition-all duration-300 hover:border-primary-300
                                     bg-white placeholder-gray-400 resize-none"
                              placeholder="Tell Linda about your inquiry..."
                              required></textarea>
                    @error('message')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="animate-fadeInUp" style="animation-delay: 0.5s">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-primary-600 to-primary-500 text-white px-8 py-5 rounded-xl
                                   hover:from-primary-700 hover:to-primary-600
                                   transition-all duration-300 font-semibold text-lg shadow-lg hover:shadow-xl
                                   transform hover:-translate-y-0.5 active:translate-y-0
                                   focus:outline-none focus:ring-4 focus:ring-primary-300">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Send Message
                        </span>
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Linda typically responds within 1-2 business days
            </p>
        </div>
    </section>
</div>
