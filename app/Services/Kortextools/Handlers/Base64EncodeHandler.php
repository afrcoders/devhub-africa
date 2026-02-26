<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Base64EncodeHandler implements ToolHandlerInterface
{
    /**
     * Handle Base64 encoding
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
            $text = $request->input('text');
            $encoded = base64_encode($text);

            return response()->json([
                'success' => true,
                'data' => [
                    'original' => $text,
                    'encoded' => $encoded,
                    'original_length' => strlen($text),
                    'encoded_length' => strlen($encoded),
                ]
            ]);
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
            'text' => 'required|string|max:100000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'encode';
    }
}
