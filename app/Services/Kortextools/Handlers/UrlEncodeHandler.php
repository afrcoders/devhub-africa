<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlEncodeHandler implements ToolHandlerInterface
{
    /**
     * Handle URL encode/decode
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
            $operation = $request->input('operation', 'encode');

            $result = match ($operation) {
                'encode' => urlencode($text),
                'decode' => urldecode($text),
                'encode_component' => rawurlencode($text),
                'decode_component' => rawurldecode($text),
                default => $text,
            };

            return response()->json([
                'success' => true,
                'data' => [
                    'result' => $result,
                    'original_length' => strlen($text),
                    'result_length' => strlen($result),
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
            'text' => 'required|string|max:50000',
            'operation' => 'required|in:encode,decode,encode_component,decode_component',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'url-encode';
    }
}
