<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RgbToHexHandler implements ToolHandlerInterface
{
    /**
     * Handle RGB to Hex conversion
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
            $operation = $request->input('operation');

            if ($operation === 'rgb_to_hex') {
                $r = (int) $request->input('r');
                $g = (int) $request->input('g');
                $b = (int) $request->input('b');

                $hex = '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) .
                       str_pad(dechex($g), 2, '0', STR_PAD_LEFT) .
                       str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'operation' => 'rgb_to_hex',
                        'rgb' => "rgb($r, $g, $b)",
                        'hex' => $hex,
                    ]
                ]);
            } else {
                $hex = $request->input('hex');
                $hex = str_replace('#', '', $hex);

                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));

                return response()->json([
                    'success' => true,
                    'data' => [
                        'operation' => 'hex_to_rgb',
                        'hex' => '#' . $hex,
                        'rgb' => "rgb($r, $g, $b)",
                        'r' => $r,
                        'g' => $g,
                        'b' => $b,
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'operation' => 'required|in:rgb_to_hex,hex_to_rgb',
            'r' => 'nullable|integer|min:0|max:255',
            'g' => 'nullable|integer|min:0|max:255',
            'b' => 'nullable|integer|min:0|max:255',
            'hex' => 'nullable|string|regex:/^#?([0-9A-Fa-f]{6}|[0-9A-Fa-f]{3})$/',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'rgb-to-hex';
    }
}
