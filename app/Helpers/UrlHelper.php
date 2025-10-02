<?php

namespace App\Helpers;

class UrlHelper
{
    public static function addUtmParameters(string $url, ?string $source = 'byek', ?string $medium = 'website', ?string $campaign = 'book_purchase'): string
    {
        if (empty($url)) {
            return $url;
        }

        $parsedUrl = parse_url($url);

        if ($parsedUrl === false) {
            return $url;
        }

        $queryParams = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        if ($source !== null) {
            $queryParams['utm_source'] = $source;
        }

        if ($medium !== null) {
            $queryParams['utm_medium'] = $medium;
        }

        if ($campaign !== null) {
            $queryParams['utm_campaign'] = $campaign;
        }

        $queryString = http_build_query($queryParams);

        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = $parsedUrl['host'] ?? '';
        $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $path = $parsedUrl['path'] ?? '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';

        return $scheme . $host . $port . $path . '?' . $queryString . $fragment;
    }
}
