<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class WebsiteScreenshotHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $url = $data['url'] ?? '';
        $width = intval($data['width'] ?? 1920);
        $height = intval($data['height'] ?? 1080);
        $format = $data['format'] ?? 'png';
        $delay = intval($data['delay'] ?? 2);

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
            // For demonstration, we'll simulate the screenshot generation
            // In a production environment, you'd use tools like:
            // - Puppeteer/Chrome headless
            // - wkHtmlToPdf
            // - External screenshot APIs

            $screenshotInfo = $this->generateScreenshotInfo($url, $width, $height, $format, $delay);

            return [
                'success' => true,
                'url' => $url,
                'screenshot' => $screenshotInfo
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Error generating screenshot: ' . $e->getMessage()
            ];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'url' => 'required|url',
            'width' => 'sometimes|integer|min:200|max:3840',
            'height' => 'sometimes|integer|min:200|max:2160',
            'format' => 'sometimes|in:png,jpg,jpeg',
            'delay' => 'sometimes|integer|min:0|max:10'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.website-screenshot';
    }

    private function generateScreenshotInfo($url, $width, $height, $format, $delay)
    {
        // Simulate basic screenshot generation
        $startTime = microtime(true);

        // Simulate processing delay
        usleep($delay * 100000); // Convert seconds to microseconds

        $endTime = microtime(true);
        $captureTime = round(($endTime - $startTime) * 1000); // Convert to milliseconds

        // Handle "full" height option
        $actualHeight = $height === 'full' ? 2000 : intval($height);

        return [
            'demo_mode' => true,
            'width' => $width,
            'height' => $actualHeight,
            'format' => $format,
            'file_size' => $this->estimateFileSize($width, $actualHeight, $format),
            'capture_time' => max($captureTime, 50), // Minimum 50ms for realism
            'data' => null, // Would contain base64 encoded image data in production
            'filename' => 'screenshot_' . date('Y-m-d_H-i-s') . '.' . $format
        ];
    }

    private function estimateFileSize($width, $height, $format)
    {
        // Rough estimation based on dimensions and format
        $pixels = $width * $height;
        $bytesPerPixel = ($format === 'png') ? 4 : 3; // PNG has alpha channel
        $estimatedBytes = $pixels * $bytesPerPixel * 0.7; // Compression factor

        if ($estimatedBytes < 1024) {
            return round($estimatedBytes) . ' B';
        } elseif ($estimatedBytes < 1048576) {
            return round($estimatedBytes / 1024, 1) . ' KB';
        } else {
            return round($estimatedBytes / 1048576, 1) . ' MB';
        }
    }
}
