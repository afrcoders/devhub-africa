<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WordCounterHandler implements ToolHandlerInterface
{
    /**
     * Handle word counting
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

            $characters = strlen($text);
            $charactersNoSpaces = strlen(str_replace(' ', '', $text));
            $words = count(array_filter(explode(' ', trim($text))));
            $sentences = count(array_filter(array_map('trim', preg_split('/[.!?]+/', $text))));
            $paragraphs = count(array_filter(explode("\n", $text), fn($p) => !empty(trim($p))));
            $lines = count(explode("\n", $text));

            return response()->json([
                'success' => true,
                'data' => [
                    'characters' => $characters,
                    'characters_no_spaces' => $charactersNoSpaces,
                    'words' => $words,
                    'sentences' => $sentences,
                    'paragraphs' => $paragraphs,
                    'lines' => $lines,
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
        return 'word-counter';
    }
}
