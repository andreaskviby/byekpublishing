<div>
    @if (session()->has('message'))
        <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-6 shadow-md animate-fadeInUp" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg mb-6 shadow-md animate-fadeInUp" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit="submit" class="space-y-6">
        <input type="text" wire:model="website" style="display: none;" tabindex="-1" autocomplete="off">

        <!-- Contact Information -->
        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 p-4 rounded-xl">
            <h4 class="text-lg font-bold text-brown-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#dac430]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Kontaktuppgifter
            </h4>

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-base font-semibold text-brown-900 mb-2">
                        Namn <span class="text-amber-600">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           wire:model="name"
                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="Ditt fullständiga namn"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-base font-semibold text-brown-900 mb-2">
                        E-post <span class="text-amber-600">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           wire:model="email"
                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="din.email@exempel.se"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-base font-semibold text-brown-900 mb-2">
                        Telefon <span class="text-amber-600">*</span>
                    </label>
                    <input type="tel"
                           id="phone"
                           wire:model="phone"
                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="+46 123 456 789"
                           required>
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 p-4 rounded-xl">
            <h4 class="text-lg font-bold text-brown-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#dac430]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Leveransadress
            </h4>

            <div class="space-y-4">
                <div>
                    <label for="streetAddress" class="block text-base font-semibold text-brown-900 mb-2">
                        Gatuadress <span class="text-amber-600">*</span>
                    </label>
                    <input type="text"
                           id="streetAddress"
                           wire:model="streetAddress"
                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="Exempelgatan 123"
                           required>
                    @error('streetAddress')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="postalCode" class="block text-base font-semibold text-brown-900 mb-2">
                            Postnummer <span class="text-amber-600">*</span>
                        </label>
                        <input type="text"
                               id="postalCode"
                               wire:model="postalCode"
                               class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                      focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                      transition-all duration-300 hover:border-primary-300
                                      bg-white placeholder-gray-400"
                               placeholder="123 45"
                               required>
                        @error('postalCode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-base font-semibold text-brown-900 mb-2">
                            Ort <span class="text-amber-600">*</span>
                        </label>
                        <input type="text"
                               id="city"
                               wire:model="city"
                               class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                      focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                      transition-all duration-300 hover:border-primary-300
                                      bg-white placeholder-gray-400"
                               placeholder="Stockholm"
                               required>
                        @error('city')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="country" class="block text-base font-semibold text-brown-900 mb-2">
                        Land <span class="text-amber-600">*</span>
                    </label>
                    <input type="text"
                           id="country"
                           wire:model="country"
                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                                  focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                                  transition-all duration-300 hover:border-primary-300
                                  bg-white placeholder-gray-400"
                           placeholder="Sverige"
                           required>
                    @error('country')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Dedication Message -->
        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 p-4 rounded-xl">
            <h4 class="text-lg font-bold text-brown-900 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#dac430]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Signerad dedikation (valfritt)
            </h4>
            <p class="text-sm text-brown-700 mb-3">Vill du att jag ska skriva en personlig hälsning i boken?</p>

            <div>
                <label for="dedicationMessage" class="block text-sm font-semibold text-brown-900 mb-2">
                    Din önskade dedikation
                </label>
                <textarea
                    id="dedicationMessage"
                    wire:model="dedicationMessage"
                    rows="3"
                    class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl shadow-sm
                           focus:ring-2 focus:ring-primary-400 focus:border-primary-500
                           transition-all duration-300 hover:border-primary-300
                           bg-white placeholder-gray-400"
                    placeholder='Exempelvis: "Till Anna, lycka till med allt! / Linda"'
                    maxlength="500"></textarea>
                <p class="mt-1 text-xs text-gray-600">Max 500 tecken</p>
                @error('dedicationMessage')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Gift Wrap Option -->
        <div class="bg-gradient-to-br from-red-50 via-green-50 to-yellow-50 p-6 rounded-xl border-2 border-[#F2D837] relative overflow-hidden">
            <div class="absolute top-0 right-0 text-6xl opacity-20">🎄</div>
            <div class="relative">
                <div class="flex items-start">
                    <input type="checkbox"
                           id="wantsGiftWrap"
                           wire:model.live="wantsGiftWrap"
                           class="mt-1 w-5 h-5 text-[#F2D837] bg-gray-100 border-gray-300 rounded
                                  focus:ring-[#dac430] focus:ring-2 cursor-pointer">
                    <label for="wantsGiftWrap" class="ml-3 cursor-pointer">
                        <span class="text-lg font-bold text-brown-900 flex items-center">
                            🎁 Julklappsinpackning (+45 SEK)
                        </span>
                        <p class="text-sm text-brown-700 mt-1">
                            Vi slår in boken i vackert julpapper med en etikett där du kan skriva avsändare.
                            Perfekt om du vill ge bort boken i present!
                        </p>
                    </label>
                </div>
                @error('wantsGiftWrap')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Price Summary -->
        <div class="bg-[#fdf8e6] border-2 border-[#F2D837] px-6 py-4 rounded-2xl text-center">
            <p class="text-sm text-brown-700 font-medium mb-1">Totalpris</p>
            <p class="text-3xl font-bold text-brown-900">
                <span x-data="{ price: @entangle('wantsGiftWrap').live }">
                    <span x-text="price ? '244' : '199'">199</span> SEK
                </span>
            </p>
            <p class="text-xs text-brown-600 mt-1">Inkl. frakt</p>
        </div>

        <button type="submit"
                class="w-full bg-[#F2D837] hover:bg-[#dac430] text-brown-900 px-8 py-4 rounded-xl
                       transition-all duration-300 font-bold text-lg shadow-lg
                       hover:shadow-xl transform hover:-translate-y-0.5 uppercase tracking-wide">
            Förbeställ nu
        </button>

        <p class="text-xs text-gray-600 text-center">
            Efter att du har skickat in formuläret får du betalningsinstruktioner via e-post.
            Betalningen måste göras inom 2 timmar för att säkra din förbeställning.
        </p>
    </form>
</div>
