<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class BrokenLinksCheckerHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $url = $data['url'] ?? '';

        if (empty($url)) {
            return [
                'success' => false,
                'error' => 'URL is required'
            ];
        }

        // Validate URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'success' => false,
                'error' => 'Please enter a valid URL'
            ];
        }

        try {
            $linkAnalysis = $this->checkBrokenLinks($url);

            return [
                'success' => true,
                'url' => $url,
                'analysis' => $linkAnalysis
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Error checking links: ' . $e->getMessage()
            ];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'url' => 'required|url'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.broken-links-checker';
    }

    private function checkBrokenLinks($url)
    {
        // Get page content
        $content = $this->getPageContent($url);
        if (!$content) {
            throw new \Exception("Could not fetch page content");
        }

        // Extract links
        $links = $this->extractLinks($content, $url);

        // Check each link
        $results = [];
        $totalLinks = count($links);
        $brokenCount = 0;
        $workingCount = 0;

        foreach ($links as $link) {
            $status = $this->checkLinkStatus($link);
            $results[] = [
                'url' => $link,
                'status_code' => $status['code'],
                'status_text' => $status['text'],
                'is_broken' => $status['broken'],
                'response_time' => $status['time']
            ];

            if ($status['broken']) {
                $brokenCount++;
            } else {
                $workingCount++;
            }
        }

        return [
            'total_links' => $totalLinks,
            'broken_links' => $brokenCount,
            'working_links' => $workingCount,
            'links' => array_slice($results, 0, 50), // Limit to first 50 for performance
            'scan_complete' => true
        ];
    }

    private function getPageContent($url)
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (compatible; LinkChecker/1.0)',
                'follow_location' => true,
                'max_redirects' => 3
            ]
        ]);

        return @file_get_contents($url, false, $context);
    }

    private function extractLinks($content, $baseUrl)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($content);

        $xpath = new \DOMXPath($dom);
        $linkElements = $xpath->query('//a[@href]');

        $links = [];
        $baseHost = parse_url($baseUrl, PHP_URL_HOST);

        foreach ($linkElements as $element) {
            $href = $element->getAttribute('href');

            // Skip empty links, mailto, tel, javascript, etc.
            if (empty($href) ||
                strpos($href, 'mailto:') === 0 ||
                strpos($href, 'tel:') === 0 ||
                strpos($href, 'javascript:') === 0 ||
                strpos($href, '#') === 0) {
                continue;
            }

            // Convert relative URLs to absolute
            if (strpos($href, 'http') !== 0) {
                if (strpos($href, '/') === 0) {
                    // Absolute path
                    $href = rtrim($baseUrl, '/') . $href;
                } else {
                    // Relative path
                    $href = rtrim($baseUrl, '/') . '/' . $href;
                }
            }

            // Only check internal links or limit external links
            $linkHost = parse_url($href, PHP_URL_HOST);
            if ($linkHost === $baseHost) {
                $links[] = $href;
            }
        }

        return array_unique($links);
    }

    private function checkLinkStatus($url)
    {
        $startTime = microtime(true);

        $context = stream_context_create([
            'http' => [
                'method' => 'HEAD',
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (compatible; LinkChecker/1.0)',
                'follow_location' => false
            ]
        ]);

        $result = @get_headers($url, 1, $context);
        $responseTime = round((microtime(true) - $startTime) * 1000);

        if (!$result) {
            return [
                'code' => 0,
                'text' => 'Connection Failed',
                'broken' => true,
                'time' => $responseTime
            ];
        }

        $statusLine = $result[0];
        preg_match('/HTTP\/[\d\.]+\s+(\d+)/', $statusLine, $matches);
        $statusCode = isset($matches[1]) ? (int) $matches[1] : 0;

        $isBroken = $statusCode >= 400 || $statusCode === 0;

        $statusTexts = [
            200 => 'OK',
            301 => 'Moved Permanently',
            302 => 'Found',
            304 => 'Not Modified',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            503 => 'Service Unavailable'
        ];

        return [
            'code' => $statusCode,
            'text' => $statusTexts[$statusCode] ?? 'Unknown',
            'broken' => $isBroken,
            'time' => $responseTime
        ];
    }
}
