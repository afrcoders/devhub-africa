<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TextToAsciiHandler implements ToolHandlerInterface
{
    /**
     * Handle text to ASCII conversion
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
            $ascii = '';

            foreach (str_split($text) as $char) {
                $ascii .= ord($char) . ' ';
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'text' => $text,
                    'ascii' => trim($ascii),
                    'characters' => strlen($text),
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
            'text' => 'required|string|max:1000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'text-to-ascii';
    }
}
