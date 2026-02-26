<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TextToBinaryHandler implements ToolHandlerInterface
{
    /**
     * Handle text to binary conversion
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
            $binary = '';

            foreach (str_split($text) as $char) {
                $binary .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT) . ' ';
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'text' => $text,
                    'binary' => trim($binary),
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
        return 'text-to-binary';
    }
}
