<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JwtDecoderHandler implements ToolHandlerInterface
{
    /**
     * Handle JWT decoding
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
            $token = trim($request->input('token'));

            // JWT format: header.payload.signature
            $parts = explode('.', $token);

            if (count($parts) !== 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JWT format. Expected 3 parts separated by dots.'
                ], 422);
            }

            // Decode header
            $header = json_decode(base64_decode(strtr($parts[0], '-_', '+/')), true);

            // Decode payload
            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

            // Get signature
            $signature = $parts[2];

            if (!$header || !$payload) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to decode JWT parts'
                ], 422);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'header' => $header,
                    'payload' => $payload,
                    'signature' => $signature,
                    'is_valid_format' => true,
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
            'token' => 'required|string|max:5000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'jwt-decoder';
    }
}
