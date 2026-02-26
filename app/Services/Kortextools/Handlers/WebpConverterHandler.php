<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class WebpConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        if (empty($data['image'])) {
            return ['success' => false, 'error' => 'No image provided'];
        }

        try {
            $imageData = $data['image'];
            $quality = intval($data['quality'] ?? 80);

            if (strpos($imageData, 'base64,') !== false) {
                list(, $imageData) = explode('base64,', $imageData);
                $imageData = base64_decode($imageData);
            }

            $image = imagecreatefromstring($imageData);
            if (!$image) {
                return ['success' => false, 'error' => 'Invalid image format'];
            }

            ob_start();
            imagewebp($image, null, $quality);
            $webpData = ob_get_clean();
            imagedestroy($image);

            if (!$webpData) {
                return ['success' => false, 'error' => 'WebP conversion not supported. Enable GD WebP support.'];
            }

            $originalSize = strlen($imageData);
            $webpSize = strlen($webpData);

            return [
                'success' => true,
                'result' => base64_encode($webpData),
                'original_size' => round($originalSize / 1024, 2) . ' KB',
                'webp_size' => round($webpSize / 1024, 2) . ' KB',
                'format' => 'WebP'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'WebP conversion failed: ' . $e->getMessage()];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'image' => 'required|string',
            'quality' => 'required|integer|min:1|max:100',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.webp-converter';
    }
}
