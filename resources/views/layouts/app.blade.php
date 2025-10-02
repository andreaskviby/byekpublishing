<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'By Ek Publishing') }} - @yield('title', 'Linda Ettehag Kviby')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-accent-100">
    <nav class="bg-white shadow-md sticky top-0 z-50" role="navigation" aria-label="Main navigation">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <span class="text-2xl font-display font-bold text-brown-900">By Ek Publishing</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                       class="text-gray-700 hover:text-primary-600 transition-colors font-medium {{ request()->routeIs('home') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}"
                       aria-current="{{ request()->routeIs('home') ? 'page' : 'false' }}">
                        Home
                    </a>
                    <a href="{{ route('author') }}"
                       class="text-gray-700 hover:text-primary-600 transition-colors font-medium {{ request()->routeIs('author') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}"
                       aria-current="{{ request()->routeIs('author') ? 'page' : 'false' }}">
                        About Linda
                    </a>
                    <a href="{{ route('books') }}"
                       class="text-gray-700 hover:text-primary-600 transition-colors font-medium {{ request()->routeIs('books') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}"
                       aria-current="{{ request()->routeIs('books') ? 'page' : 'false' }}">
                        Books
                    </a>
                    <a href="{{ route('art') }}"
                       class="text-gray-700 hover:text-primary-600 transition-colors font-medium {{ request()->routeIs('art') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}"
                       aria-current="{{ request()->routeIs('art') ? 'page' : 'false' }}">
                        Art
                    </a>
                    <a href="{{ route('music') }}"
                       class="text-gray-700 hover:text-primary-600 transition-colors font-medium {{ request()->routeIs('music') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}"
                       aria-current="{{ request()->routeIs('music') ? 'page' : 'false' }}">
                        Music
                    </a>
                    <a href="{{ route('videos') }}"
                       class="text-gray-700 hover:text-primary-600 transition-colors font-medium {{ request()->routeIs('videos') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}"
                       aria-current="{{ request()->routeIs('videos') ? 'page' : 'false' }}">
                        Videos
                    </a>
                    <a href="{{ route('contact') }}"
                       class="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition-colors font-medium">
                        Contact
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button type="button"
                            class="text-gray-700 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600"
                            aria-label="Toggle menu"
                            aria-expanded="false"
                            x-data="{ open: false }"
                            @click="open = !open">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="md:hidden" x-data="{ open: false }" x-show="open" @click.away="open = false">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white shadow-lg">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-accent-50 hover:text-primary-600 rounded-md">Home</a>
                <a href="{{ route('author') }}" class="block px-3 py-2 text-gray-700 hover:bg-accent-50 hover:text-primary-600 rounded-md">About Linda</a>
                <a href="{{ route('books') }}" class="block px-3 py-2 text-gray-700 hover:bg-accent-50 hover:text-primary-600 rounded-md">Books</a>
                <a href="{{ route('art') }}" class="block px-3 py-2 text-gray-700 hover:bg-accent-50 hover:text-primary-600 rounded-md">Art</a>
                <a href="{{ route('music') }}" class="block px-3 py-2 text-gray-700 hover:bg-accent-50 hover:text-primary-600 rounded-md">Music</a>
                <a href="{{ route('videos') }}" class="block px-3 py-2 text-gray-700 hover:bg-accent-50 hover:text-primary-600 rounded-md">Videos</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-md">Contact</a>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-brown-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-display font-semibold mb-4">By Ek Publishing</h3>
                    <p class="text-accent-300">Books, Art, and Music by Linda Ettehag Kviby</p>
                </div>

                <div>
                    <h3 class="text-xl font-display font-semibold mb-4">Quick Links</h3>
                    <nav aria-label="Footer navigation">
                        <ul class="space-y-2">
                            <li><a href="{{ route('books') }}" class="text-accent-300 hover:text-white transition-colors">Books</a></li>
                            <li><a href="{{ route('art') }}" class="text-accent-300 hover:text-white transition-colors">Art Gallery</a></li>
                            <li><a href="{{ route('music') }}" class="text-accent-300 hover:text-white transition-colors">Music</a></li>
                            <li><a href="{{ route('contact') }}" class="text-accent-300 hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </nav>
                </div>

                <div>
                    <h3 class="text-xl font-display font-semibold mb-4">AI Transparency</h3>
                    <p class="text-accent-300 text-sm">
                        We only use AI for research and music production. All book content and YouTube videos are created by humans.
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-brown-800 text-center text-accent-300">
                <p>&copy; {{ date('Y') }} By Ek Publishing. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
