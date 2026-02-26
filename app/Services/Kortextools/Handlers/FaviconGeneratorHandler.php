<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class FaviconGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        try {
            $text = substr($data['text'] ?? 'A', 0, 1);
            $bgColor = $data['bg_color'] ?? '#3498db';
            $textColor = $data['text_color'] ?? '#ffffff';
            $size = intval($data['size'] ?? 32);

            // Create image
            $image = imagecreatetruecolor($size, $size);
            
            // Parse colors
            $bg = $this->hexToRgb($bgColor);
            $text = $this->hexToRgb($textColor);
            
            $bgIndex = imagecolorallocate($image, $bg['r'], $bg['g'], $bg['b']);
            $textIndex = imagecolorallocate($image, $text['r'], $text['g'], $text['b']);

            // Fill background
            imagefilledrectangle($image, 0, 0, $size - 1, $size - 1, $bgIndex);

            // Add text
            $fontSize = max(1, intval($size / 3));
            imagestring($image, $fontSize, intval($size / 4), intval($size / 4), strtoupper($text), $textIndex);

            // Convert to PNG
            ob_start();
            imagepng($image);
            $faviconData = ob_get_clean();
            imagedestroy($image);

            return [
                'success' => true,
                'result' => base64_encode($faviconData),
                'size' => $size . 'x' . $size,
                'format' => 'PNG (ICO)'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Favicon generation failed: ' . $e->getMessage()];
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
            'text' => 'required|string|max:1',
            'bg_color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'text_color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'size' => 'required|integer|min:16|max:256',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.favicon-generator';
    }
}
