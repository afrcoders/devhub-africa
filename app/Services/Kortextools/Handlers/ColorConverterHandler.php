<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorConverterHandler implements ToolHandlerInterface
{
    /**
     * Handle color conversion between HEX, RGB, HSL
     */
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $colorType = $request->input('color_type', 'hex');
            $colorValue = $request->input('color_value');

            $result = [];

            switch ($colorType) {
                case 'hex':
                    $result = $this->convertFromHex($colorValue);
                    break;
                case 'rgb':
                    $r = $request->input('r');
                    $g = $request->input('g');
                    $b = $request->input('b');
                    $result = $this->convertFromRgb($r, $g, $b);
                    break;
                case 'hsl':
                    $h = $request->input('h');
                    $s = $request->input('s');
                    $l = $request->input('l');
                    $result = $this->convertFromHsl($h, $s, $l);
                    break;
            }

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function convertFromHex($hex)
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $hsl = $this->rgbToHsl($r, $g, $b);

        return [
            'hex' => '#' . strtoupper($hex),
            'rgb' => "rgb($r, $g, $b)",
            'r' => $r,
            'g' => $g,
            'b' => $b,
            'hsl' => "hsl({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%)",
            'h' => $hsl['h'],
            's' => $hsl['s'],
            'l' => $hsl['l']
        ];
    }

    private function convertFromRgb($r, $g, $b)
    {
        $hex = sprintf("#%02X%02X%02X", $r, $g, $b);
        $hsl = $this->rgbToHsl($r, $g, $b);

        return [
            'hex' => $hex,
            'rgb' => "rgb($r, $g, $b)",
            'r' => $r,
            'g' => $g,
            'b' => $b,
            'hsl' => "hsl({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%)",
            'h' => $hsl['h'],
            's' => $hsl['s'],
            'l' => $hsl['l']
        ];
    }

    private function convertFromHsl($h, $s, $l)
    {
        $rgb = $this->hslToRgb($h, $s, $l);
        $hex = sprintf("#%02X%02X%02X", $rgb['r'], $rgb['g'], $rgb['b']);

        return [
            'hex' => $hex,
            'rgb' => "rgb({$rgb['r']}, {$rgb['g']}, {$rgb['b']})",
            'r' => $rgb['r'],
            'g' => $rgb['g'],
            'b' => $rgb['b'],
            'hsl' => "hsl($h, $s%, $l%)",
            'h' => $h,
            's' => $s,
            'l' => $l
        ];
    }

    private function rgbToHsl($r, $g, $b)
    {
        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $h = $s = $l = ($max + $min) / 2;

        if ($max == $min) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

            switch ($max) {
                case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
                case $g: $h = ($b - $r) / $d + 2; break;
                case $b: $h = ($r - $g) / $d + 4; break;
            }
            $h /= 6;
        }

        return [
            'h' => round($h * 360),
            's' => round($s * 100),
            'l' => round($l * 100)
        ];
    }

    private function hslToRgb($h, $s, $l)
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;

        if ($s == 0) {
            $r = $g = $b = $l;
        } else {
            $hue2rgb = function($p, $q, $t) {
                if ($t < 0) $t += 1;
                if ($t > 1) $t -= 1;
                if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
                if ($t < 1/2) return $q;
                if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
                return $p;
            };

            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;

            $r = $hue2rgb($p, $q, $h + 1/3);
            $g = $hue2rgb($p, $q, $h);
            $b = $hue2rgb($p, $q, $h - 1/3);
        }

        return [
            'r' => round($r * 255),
            'g' => round($g * 255),
            'b' => round($b * 255)
        ];
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'color_type' => 'required|string|in:hex,rgb,hsl',
            'color_value' => 'nullable|string',
            'r' => 'nullable|integer|min:0|max:255',
            'g' => 'nullable|integer|min:0|max:255',
            'b' => 'nullable|integer|min:0|max:255',
            'h' => 'nullable|integer|min:0|max:360',
            's' => 'nullable|integer|min:0|max:100',
            'l' => 'nullable|integer|min:0|max:100',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'color-converter';
    }
}
