<div>
    <section class="bg-gradient-to-r from-accent-100 to-primary-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-brown-900 mb-4 text-center">Contact Linda</h1>
            <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto">Have questions about art or want to get in touch?</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <form wire:submit="submit" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name <span class="text-red-600">*</span></label>
                    <input type="text"
                           id="name"
                           wire:model="name"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                    <input type="email"
                           id="email"
                           wire:model="email"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject <span class="text-red-600">*</span></label>
                    <input type="text"
                           id="subject"
                           wire:model="subject"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                           required>
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message <span class="text-red-600">*</span></label>
                    <textarea id="message"
                              wire:model="message"
                              rows="6"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                              required></textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                            class="w-full bg-primary-600 text-white px-6 py-3 rounded-full hover:bg-primary-700 transition-colors font-medium text-lg">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
