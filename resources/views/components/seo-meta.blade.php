@props(['seoData', 'structuredData' => null])

{{-- Basic Meta Tags --}}
<meta name="description" content="{{ $seoData['description'] ?? '' }}">
<meta name="keywords" content="{{ $seoData['keywords'] ?? '' }}">
<meta name="author" content="{{ $seoData['author'] ?? 'Linda Ettehag Kviby' }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="{{ $seoData['url'] ?? url()->current() }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $seoData['title'] ?? config('app.name') }}">
<meta property="og:description" content="{{ $seoData['description'] ?? '' }}">
<meta property="og:image" content="{{ $seoData['image'] ?? asset('images/default-og-image.jpg') }}">
<meta property="og:url" content="{{ $seoData['url'] ?? url()->current() }}">
<meta property="og:type" content="{{ $seoData['type'] ?? 'website' }}">
<meta property="og:site_name" content="{{ $seoData['site_name'] ?? config('app.name') }}">
<meta property="og:locale" content="{{ $seoData['og:locale'] ?? 'sv_SE' }}">
<meta property="og:image:width" content="{{ $seoData['og:image:width'] ?? '1200' }}">
<meta property="og:image:height" content="{{ $seoData['og:image:height'] ?? '630' }}">

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="{{ $seoData['twitter:card'] ?? 'summary_large_image' }}">
<meta name="twitter:site" content="{{ $seoData['twitter:site'] ?? '@lindaettehagkviby' }}">
<meta name="twitter:creator" content="{{ $seoData['twitter:creator'] ?? '@lindaettehagkviby' }}">
<meta name="twitter:title" content="{{ $seoData['title'] ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $seoData['description'] ?? '' }}">
<meta name="twitter:image" content="{{ $seoData['image'] ?? asset('images/default-og-image.jpg') }}">

{{-- JSON-LD Structured Data --}}
@if($structuredData)
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
