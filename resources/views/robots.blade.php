User-agent: *
Disallow: /admin
Disallow: /livewire
Disallow: /*.json
Disallow: /storage/app/
Allow: /storage/
Allow: /images/
Allow: /

# Specific rules for major search engines
User-agent: Googlebot
Allow: /

User-agent: Bingbot
Allow: /

User-agent: Slurp
Allow: /

# Sitemaps
Sitemap: {{ url('/sitemap.xml') }}

# Crawl-delay for respectful crawling
Crawl-delay: 1