<div @if($event->page_color) style="background-color: {{ $event->page_color }};" @endif>
    <section class="relative bg-gradient-to-br from-amber-50 via-yellow-50 to-accent-100 py-20 overflow-hidden"
        style="
            @if($event->page_color) background-color: {{ $event->page_color }}; @endif
            @if($event->hero_banner_image) background-image: url('{{ Storage::url($event->hero_banner_image) }}'); background-size: contain; background-repeat: no-repeat; @endif
        ">
        @if($event->hero_banner_image)
            <!-- Overlay for better text readability when using custom banner -->
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50/90 via-yellow-50/90 to-accent-100/90"></div>
        @endif

        @if($event->hero_graphic_image)
            <!-- Decorative graphic on left side -->
            <div class="absolute top-1/2 -translate-y-1/2 left-0 lg:left-8 xl:left-16 w-[280px] h-[350px] z-10">
                <img src="{{ Storage::url($event->hero_graphic_image) }}" alt="Decorative graphic" class="w-full h-full object-cover object-left-bottom">
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-6">
                @if($event->hero_subtitle)
                    <p class="text-sm uppercase tracking-wider mb-2 font-medium"
                       @if($event->hero_text_color) style="color: {{ $event->hero_text_color }};" @else style="color: #78350f;" @endif>
                        {{ $event->hero_subtitle }}
                    </p>
                @endif
                <h1 class="text-5xl md:text-6xl font-display font-bold mb-4 leading-tight"
                    @if($event->hero_text_color) style="color: {{ $event->hero_text_color }};" @else style="color: #292524;" @endif>
                    {{ $event->title }}
                </h1>
                @if($event->hero_badge_text)
                    <div class="inline-block bg-amber-400 px-8 py-3 rounded-full">
                        <p class="text-lg md:text-xl font-bold text-brown-900 uppercase tracking-wide">{{ $event->hero_badge_text }}</p>
                    </div>
                @endif
            </div>

            @if($event->hero_call_to_action)
                <div class="mt-8 text-center">
                    <p class="text-2xl font-display font-bold mb-2"
                       @if($event->hero_text_color) style="color: {{ $event->hero_text_color }};" @else style="color: #292524;" @endif>
                        {{ $event->hero_call_to_action }}
                    </p>
                </div>
            @endif
        </div>
    </section>

    <section class="py-16" @if($event->page_color) style="background-color: {{ $event->page_color }};" @else style="background-color: white;" @endif>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Event Details -->
                <div>
                    <div class="bg-white p-8 rounded-3xl shadow-xl mb-8 border-2 border-gray-200">
                        <h2 class="text-3xl font-display font-bold text-brown-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Evenemangsdetaljer
                        </h2>

                        <div class="space-y-6">
                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Datum</div>
                                    <div class="text-lg font-bold text-brown-900">{{ $event->event_date->locale('sv')->isoFormat('D MMMM YYYY') }}</div>
                                    <div class="text-sm text-gray-600">{{ $event->event_date->locale('sv')->isoFormat('dddd') }}</div>
                                </div>
                            </div>

                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Tid</div>
                                    <div class="text-lg font-bold text-brown-900">
                                        Kl. {{ $event->start_time }}
                                        @if($event->end_time)
                                            - {{ $event->end_time }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Plats</div>
                                    <div class="text-lg font-bold text-brown-900">{{ $event->street_address }}</div>
                                </div>
                            </div>

                            <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-brown-700 uppercase tracking-wide mb-1">Tillgängliga platser</div>
                                    <div class="text-lg font-bold text-brown-900">
                                        {{ $event->availableSpots() }} av {{ $event->max_attendees }} platser kvar
                                    </div>
                                    @if($event->availableSpots() <= 10 && $event->availableSpots() > 0)
                                        <div class="text-sm text-amber-700 font-semibold mt-1">⚠️ Bara några platser kvar!</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border-2 border-gray-200">
                        <h3 class="text-2xl font-display font-bold text-brown-900 mb-4 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Om evenemanget
                        </h3>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $event->description }}</p>
                    </div>
                </div>

                <!-- RSVP Form -->
                <div class="lg:sticky lg:top-8 h-fit">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border-2 border-gray-200">
                        <div class="text-center mb-6">
                            <h3 class="text-3xl font-display font-bold text-brown-900 mb-2">OSA här</h3>
                            <p class="text-gray-600">Anmäl ditt intresse för evenemanget</p>
                        </div>

                        @if($event->isFull())
                            <div class="bg-red-50 border-2 border-red-500 text-red-800 px-6 py-4 rounded-2xl mb-6 text-center" role="alert">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <p class="font-bold text-lg">Detta evenemang är fullbokat</p>
                            </div>
                        @else
                            <livewire:event-rsvp-form :event="$event" />
                        @endif
                    </div>

                    <!-- Social reminder -->
                    <a href="https://instagram.com/lindaettehagkviby" target="_blank" class="mt-6 bg-white text-black p-6 rounded-2xl text-center shadow-lg border-2 border-gray-200 block hover:shadow-xl transition-shadow duration-300">
                        <p class="text-lg font-semibold mb-2">Följ mig på Instagram</p>
                        <p class="text-brown-900 font-bold text-xl">@lindaettehagkviby</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
