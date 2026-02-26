<?php

namespace App\Services\Kortextools\Handlers;

class UrlValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $url = $data['url'] ?? '';

        if (empty(trim($url))) {
            return [
                'success' => false,
                'is_valid' => false,
                'error' => 'URL is empty',
            ];
        }

        // Add protocol if missing
        if (!preg_match('~^(?:f|ht)tps?://~i', $url)) {
            $url = 'http://' . $url;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return [
                'success' => false,
                'is_valid' => false,
                'error' => 'Invalid URL format',
            ];
        }

        $parsed = parse_url($url);

        return [
            'success' => true,
            'is_valid' => true,
            'message' => 'Valid URL',
            'url' => $url,
            'scheme' => $parsed['scheme'] ?? '',
            'host' => $parsed['host'] ?? '',
            'path' => $parsed['path'] ?? '/',
            'query' => $parsed['query'] ?? '',
            'port' => $parsed['port'] ?? '',
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'url' => 'required|string',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.url-validator';
    }
}
