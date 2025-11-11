<div>
    @push('meta')
        <x-seo-meta :seoData="$seoData" :structuredData="$structuredData" />
    @endpush

    <section class="bg-gradient-to-br from-amber-50 via-yellow-50 to-accent-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl md:text-6xl font-display font-bold text-brown-900 mb-4 text-center">About Linda Ettehag Kviby</h1>
            <p class="text-xl text-center text-brown-700 font-medium">Author, Artist & Creative Soul</p>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Image Section -->
                <div class="flex justify-center lg:justify-end order-1 lg:order-1">
                    <div class="relative">
                        <!-- Decorative background element -->
                        <div class="absolute -inset-4 rounded-3xl opacity-20 blur-2xl" style="background-color: #F2D837;"></div>

                        <!-- Image container with border -->
                        <div class="relative rounded-3xl p-2 shadow-2xl" style="background: linear-gradient(135deg, #F2D837 0%, #E5C832 100%);">
                            <div class="rounded-2xl overflow-hidden shadow-inner">
                                <img src="/images/linda.jpeg"
                                     alt="Linda Ettehag Kviby"
                                     class="w-full h-auto object-cover"
                                     style="max-width: 500px;">
                            </div>
                        </div>

                        <!-- Decorative corner accent -->
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full opacity-60 blur-xl" style="background-color: #F2D837;"></div>
                    </div>
                </div>

                <!-- Text Section -->
                <div class="order-2 lg:order-2">
                    <div class="space-y-6">
                        <div class="inline-block px-6 py-2 rounded-full mb-4" style="background-color: #FEF9E7; border: 2px solid #F2D837;">
                            <span class="font-bold text-brown-900">Author, Artist & YouTuber</span>
                        </div>

                        <p class="text-xl text-gray-800 leading-relaxed font-medium">
                            Linda Ettehag Kviby is a multi-talented author, artist, and creative explorer whose work speaks to the heart and soul.
                        </p>

                        <p class="text-lg text-gray-700 leading-relaxed">
                            Her debut novel, "Shadow of a Butterfly," has touched readers across multiple languages, exploring themes of transformation, resilience, and the delicate beauty of human connections.
                        </p>

                        <p class="text-lg text-gray-700 leading-relaxed">
                            Beyond writing, Linda expresses her creativity through visual art and experimental music production, where she embraces AI as a tool for musical composition while maintaining human authenticity in all written and video content.
                        </p>

                        <p class="text-lg text-gray-700 leading-relaxed">
                            Through her work, Linda aims to create emotional resonance that transcends borders and languages, connecting with women aged 30-70 who appreciate depth, beauty, and authentic storytelling.
                        </p>

                        <!-- Social Links -->
                        <div class="pt-6 flex flex-wrap gap-4">
                            <a href="https://instagram.com/lindaettehagkviby"
                               target="_blank"
                               class="inline-flex items-center px-6 py-3 rounded-xl font-semibold text-brown-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                               style="background-color: #F2D837;"
                               onmouseover="this.style.backgroundColor='#E5C832'"
                               onmouseout="this.style.backgroundColor='#F2D837'">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                Follow on Instagram
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
