<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TextCaseHandler implements ToolHandlerInterface
{
    /**
     * Handle text case conversion
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
            $caseType = $request->input('case_type', 'lowercase');

            $result = match ($caseType) {
                'uppercase' => strtoupper($text),
                'lowercase' => strtolower($text),
                'titlecase' => ucwords(strtolower($text)),
                'sentencecase' => ucfirst(strtolower($text)),
                'togglecase' => $this->toggleCase($text),
                'capitalize' => $this->capitalizeWords($text),
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
            'case_type' => 'required|in:uppercase,lowercase,titlecase,sentencecase,togglecase,capitalize',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'text-case';
    }

    /**
     * Toggle case: uppercase becomes lowercase and vice versa
     */
    protected function toggleCase($text)
    {
        return implode('', array_map(function ($char) {
            return ctype_upper($char) ? strtolower($char) : strtoupper($char);
        }, str_split($text)));
    }

    /**
     * Capitalize first letter of each word
     */
    protected function capitalizeWords($text)
    {
        return ucwords(strtolower($text), " \t\r\n\f\v");
    }
}
