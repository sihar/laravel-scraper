<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use DOMDocument;
use DOMXPath;

class PortfolioScraper
{
    public function scrape(string $url): array
    {
        $config = config('scrapers');
        $host = parse_url($url, PHP_URL_HOST);
        // dd($config);

        // Try exact match first
        $rules = $config[$host] ?? null;

        // If not found, try wildcard fallback
        if (!$rules) {
            foreach ($config as $pattern => $rule) {
                if (str_starts_with($pattern, '*.') && str_ends_with($host, substr($pattern, 1))) {
                    $rules = $rule;
                    break;
                }
            }
        }

        if (!$rules) {
            throw new \Exception("No scraper config found for: $host");
        }

        $html = Browsershot::url($url)
            ->waitUntilNetworkIdle()
            ->timeout(60)
            ->bodyHtml();

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);


        $nodes = $xpath->query($rules['pattern']);
        $items = [];

        foreach ($nodes as $node) {
            $items[] = trim($node->textContent);
        }

        foreach ($rules['fields'] as $field => $rule) {
            $data[$field] = $items[$rule['position']] ?? null;
        }

        return $data;
    }
}
