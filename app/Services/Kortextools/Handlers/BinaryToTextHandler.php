<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BinaryToTextHandler implements ToolHandlerInterface
{
    /**
     * Handle binary to text conversion
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
            $binary = $request->input('binary');
            $binary = trim($binary);
            $binaryArray = explode(' ', $binary);

            $text = '';
            foreach ($binaryArray as $byte) {
                if (!empty($byte)) {
                    $text .= chr(bindec($byte));
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'binary' => $binary,
                    'text' => $text,
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
            'binary' => 'required|string|max:5000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'binary-to-text';
    }
}
