<div>
    @if($event->isFull())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg mb-6" role="alert">
            <p class="font-medium">Detta evenemang är fullbokat.</p>
        </div>
    @else
        <div class="px-6 py-4 rounded-2xl mb-6 text-center" style="background-color: #FEF9E7; border: 2px solid #F2D837;">
            <p class="text-sm text-brown-700 font-medium">
                <span class="text-2xl font-bold" style="color: #F2D837;">{{ $event->availableSpots() }}</span> platser kvar av <span class="font-bold">{{ $event->max_attendees }}</span>
            </p>
        </div>

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

            <div>
                <label for="name" class="block text-base font-semibold text-brown-900 mb-3">
                    Namn <span class="text-amber-600">*</span>
                </label>
                <input type="text"
                       id="name"
                       wire:model="name"
                       class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                              transition-all duration-300
                              bg-white placeholder-gray-400"
                       style="--tw-ring-color: #F2D837;"
                       onmouseover="this.style.borderColor='#F2D837'"
                       onmouseout="if(!this.matches(':focus')) this.style.borderColor=''"
                       onfocus="this.style.borderColor='#F2D837'; this.style.outline='2px solid #F2D837'; this.style.outlineOffset='0px';"
                       onblur="this.style.borderColor=''; this.style.outline='';"
                       placeholder="Ditt fullständiga namn"
                       required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-base font-semibold text-brown-900 mb-3">
                    E-post <span class="text-amber-600">*</span>
                </label>
                <input type="email"
                       id="email"
                       wire:model="email"
                       class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                              transition-all duration-300
                              bg-white placeholder-gray-400"
                       style="--tw-ring-color: #F2D837;"
                       onmouseover="this.style.borderColor='#F2D837'"
                       onmouseout="if(!this.matches(':focus')) this.style.borderColor=''"
                       onfocus="this.style.borderColor='#F2D837'; this.style.outline='2px solid #F2D837'; this.style.outlineOffset='0px';"
                       onblur="this.style.borderColor=''; this.style.outline='';"
                       placeholder="din.email@exempel.se"
                       required>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-base font-semibold text-brown-900 mb-3">
                    Telefon <span class="text-amber-600">*</span>
                </label>
                <input type="tel"
                       id="phone"
                       wire:model="phone"
                       class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                              transition-all duration-300
                              bg-white placeholder-gray-400"
                       style="--tw-ring-color: #F2D837;"
                       onmouseover="this.style.borderColor='#F2D837'"
                       onmouseout="if(!this.matches(':focus')) this.style.borderColor=''"
                       onfocus="this.style.borderColor='#F2D837'; this.style.outline='2px solid #F2D837'; this.style.outlineOffset='0px';"
                       onblur="this.style.borderColor=''; this.style.outline='';"
                       placeholder="+46 123 456 789"
                       required>
                @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="numberOfGuests" class="block text-base font-semibold text-brown-900 mb-3">
                    Antal gäster <span class="text-amber-600">*</span>
                </label>
                <select id="numberOfGuests"
                        wire:model="numberOfGuests"
                        class="w-full px-5 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm
                               transition-all duration-300
                               bg-white"
                        style="--tw-ring-color: #F2D837;"
                        onmouseover="this.style.borderColor='#F2D837'"
                        onmouseout="if(!this.matches(':focus')) this.style.borderColor=''"
                        onfocus="this.style.borderColor='#F2D837'; this.style.outline='2px solid #F2D837'; this.style.outlineOffset='0px';"
                        onblur="this.style.borderColor=''; this.style.outline='';"
                        required>
                    <option value="1">1 person</option>
                    <option value="2">2 personer</option>
                    <option value="3">3 personer</option>
                    <option value="4">4 personer</option>
                </select>
                @error('numberOfGuests')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full text-brown-900 px-8 py-4 rounded-xl
                           transition-all duration-300 font-bold text-lg shadow-lg
                           hover:shadow-xl transform hover:-translate-y-0.5 uppercase tracking-wide"
                    style="background-color: #F2D837;"
                    onmouseover="this.style.backgroundColor='#E5C832'"
                    onmouseout="this.style.backgroundColor='#F2D837'">
                Anmäl dig nu
            </button>
        </form>
    @endif
</div>
