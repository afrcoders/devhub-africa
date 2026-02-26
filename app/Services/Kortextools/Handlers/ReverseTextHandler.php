<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReverseTextHandler implements ToolHandlerInterface
{
    /**
     * Handle reverse text
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
            $reversed = strrev($text);

            return response()->json([
                'success' => true,
                'data' => [
                    'original' => $text,
                    'reversed' => $reversed,
                    'length' => strlen($text),
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
            'text' => 'required|string|max:10000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'reverse-text';
    }
}
