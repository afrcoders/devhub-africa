<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class HttpHeaderViewerHandler implements ToolHandlerInterface
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

        // Add protocol if not present
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'success' => false,
                'error' => 'Please enter a valid URL'
            ];
        }

        try {
            $headers = $this->getHttpHeaders($url);

            return [
                'success' => true,
                'url' => $url,
                'headers' => $headers
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to fetch headers: ' . $e->getMessage()
            ];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'url' => 'required|string|max:2000'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.http-header-viewer';
    }

    private function getHttpHeaders($url)
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (compatible; KortexTools HTTP Header Viewer)',
                'follow_location' => true,
                'max_redirects' => 5
            ]
        ]);

        // Use get_headers to get response headers
        $headers = get_headers($url, 1, $context);

        if (!$headers) {
            throw new \Exception('Unable to fetch headers from the URL');
        }

        // Parse the headers into a more readable format
        $parsedHeaders = [];
        $statusLine = '';

        foreach ($headers as $key => $value) {
            if (is_numeric($key)) {
                // This is the status line
                if (empty($statusLine)) {
                    $statusLine = $value;
                }
            } else {
                // Regular header
                if (is_array($value)) {
                    $parsedHeaders[$key] = implode(', ', $value);
                } else {
                    $parsedHeaders[$key] = $value;
                }
            }
        }

        return [
            'status_line' => $statusLine,
            'headers' => $parsedHeaders,
            'security_analysis' => $this->analyzeSecurityHeaders($parsedHeaders)
        ];
    }

    private function analyzeSecurityHeaders($headers)
    {
        $analysis = [];

        // Check for important security headers
        $securityHeaders = [
            'Strict-Transport-Security' => 'HSTS - Forces HTTPS connections',
            'Content-Security-Policy' => 'CSP - Prevents XSS and injection attacks',
            'X-Frame-Options' => 'Prevents clickjacking attacks',
            'X-Content-Type-Options' => 'Prevents MIME type sniffing',
            'X-XSS-Protection' => 'Legacy XSS protection',
            'Referrer-Policy' => 'Controls referrer information',
            'Permissions-Policy' => 'Controls browser features'
        ];

        foreach ($securityHeaders as $header => $description) {
            $analysis[$header] = [
                'present' => isset($headers[$header]),
                'value' => $headers[$header] ?? null,
                'description' => $description
            ];
        }

        return $analysis;
    }
}
