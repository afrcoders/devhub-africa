<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Base64DecodeHandler implements ToolHandlerInterface
{
    /**
     * Handle Base64 decoding
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
            $decoded = base64_decode($text, true);

            if ($decoded === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Base64 input. Please check your data and try again.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'original' => $text,
                    'decoded' => $decoded,
                    'original_length' => strlen($text),
                    'decoded_length' => strlen($decoded),
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
        return 'decode';
    }
}
