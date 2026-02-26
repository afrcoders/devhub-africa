<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DecimalToHexHandler implements ToolHandlerInterface
{
    /**
     * Handle decimal to hex conversion
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

            if ($operation === 'decimal_to_hex') {
                $decimal = (int) $request->input('decimal');
                $hex = dechex($decimal);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'operation' => 'decimal_to_hex',
                        'decimal' => $decimal,
                        'hex' => $hex,
                    ]
                ]);
            } else {
                $hex = $request->input('hex');
                $decimal = hexdec($hex);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'operation' => 'hex_to_decimal',
                        'hex' => $hex,
                        'decimal' => $decimal,
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
            'operation' => 'required|in:decimal_to_hex,hex_to_decimal',
            'decimal' => 'nullable|integer|min:0',
            'hex' => 'nullable|string',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'decimal-to-hex';
    }
}
