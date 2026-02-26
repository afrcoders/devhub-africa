<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class ImageCompressorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        if (empty($data['image'])) {
            return ['success' => false, 'error' => 'No image provided'];
        }

        try {
            $imageData = $data['image'];
            $quality = intval($data['quality'] ?? 75);
            $quality = min(100, max(1, $quality));

            if (strpos($imageData, 'base64,') !== false) {
                list(, $imageData) = explode('base64,', $imageData);
                $imageData = base64_decode($imageData);
            }

            $image = imagecreatefromstring($imageData);
            if (!$image) {
                return ['success' => false, 'error' => 'Invalid image format'];
            }

            ob_start();
            imagejpeg($image, null, $quality);
            $compressedData = ob_get_clean();
            imagedestroy($image);

            $originalSize = strlen($imageData);
            $compressedSize = strlen($compressedData);
            $reduction = round(((($originalSize - $compressedSize) / $originalSize) * 100), 2);

            return [
                'success' => true,
                'result' => base64_encode($compressedData),
                'original_size' => round($originalSize / 1024, 2) . ' KB',
                'compressed_size' => round($compressedSize / 1024, 2) . ' KB',
                'reduction' => $reduction . '%'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Compression failed: ' . $e->getMessage()];
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
        return 'africoders.kortextools.tools.image-compressor';
    }
}
