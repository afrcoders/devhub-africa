<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class PngToJpgConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        if (empty($data['image'])) {
            return ['success' => false, 'error' => 'No image provided'];
        }

        try {
            $imageData = $data['image'];
            $quality = intval($data['quality'] ?? 85);
            $bgColor = $data['bg_color'] ?? '#ffffff';

            if (strpos($imageData, 'base64,') !== false) {
                list(, $imageData) = explode('base64,', $imageData);
                $imageData = base64_decode($imageData);
            }

            $image = imagecreatefromstring($imageData);
            if (!$image) {
                return ['success' => false, 'error' => 'Invalid image format'];
            }

            $width = imagesx($image);
            $height = imagesy($image);

            // Create JPG background
            $jpg = imagecreatetruecolor($width, $height);
            
            $rgb = $this->hexToRgb($bgColor);
            $bgIndex = imagecolorallocate($jpg, $rgb['r'], $rgb['g'], $rgb['b']);
            imagefilledrectangle($jpg, 0, 0, $width - 1, $height - 1, $bgIndex);

            // Copy image to JPG
            imagecopy($jpg, $image, 0, 0, 0, 0, $width, $height);

            ob_start();
            imagejpeg($jpg, null, $quality);
            $jpgData = ob_get_clean();

            imagedestroy($image);
            imagedestroy($jpg);

            $originalSize = strlen($imageData);
            $jpgSize = strlen($jpgData);

            return [
                'success' => true,
                'result' => base64_encode($jpgData),
                'original_size' => round($originalSize / 1024, 2) . ' KB',
                'converted_size' => round($jpgSize / 1024, 2) . ' KB',
                'dimensions' => $width . 'x' . $height
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Conversion failed: ' . $e->getMessage()];
        }
    }

    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'image' => 'required|string',
            'quality' => 'required|integer|min:1|max:100',
            'bg_color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.png-to-jpg';
    }
}
