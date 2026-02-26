<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class ImageResizerHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        if (empty($data['image'])) {
            return ['success' => false, 'error' => 'No image provided'];
        }

        try {
            $imageData = $data['image'];
            $width = intval($data['width'] ?? 800);
            $height = intval($data['height'] ?? 600);
            $maintain_aspect = $data['maintain_aspect'] ?? true;

            if ($width <= 0 || $height <= 0) {
                return ['success' => false, 'error' => 'Invalid dimensions'];
            }

            // For base64 image
            if (strpos($imageData, 'base64,') !== false) {
                list(, $imageData) = explode('base64,', $imageData);
                $imageData = base64_decode($imageData);
            }

            $image = imagecreatefromstring($imageData);
            if (!$image) {
                return ['success' => false, 'error' => 'Invalid image format'];
            }

            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            if ($maintain_aspect) {
                $aspectRatio = $originalWidth / $originalHeight;
                if ($width / $height > $aspectRatio) {
                    $width = intval($height * $aspectRatio);
                } else {
                    $height = intval($width / $aspectRatio);
                }
            }

            $resized = imagecreatetruecolor($width, $height);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

            ob_start();
            imagejpeg($resized, null, 85);
            $resizedData = ob_get_clean();

            imagedestroy($image);
            imagedestroy($resized);

            return [
                'success' => true,
                'result' => base64_encode($resizedData),
                'original_size' => $originalWidth . 'x' . $originalHeight,
                'new_size' => $width . 'x' . $height
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Image processing failed: ' . $e->getMessage()];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'image' => 'required|string',
            'width' => 'required|integer|min:1|max:5000',
            'height' => 'required|integer|min:1|max:5000',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.image-resizer';
    }
}
