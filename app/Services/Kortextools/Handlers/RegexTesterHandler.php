<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegexTesterHandler implements ToolHandlerInterface
{
    /**
     * Handle regex testing
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
            $pattern = $request->input('pattern');
            $text = $request->input('text');
            $modifiers = $request->input('modifiers', '');

            // Build the full regex pattern with modifiers
            $fullPattern = '/' . str_replace('/', '\\/', $pattern) . '/' . $modifiers;

            // Test if pattern is valid
            if (@preg_match($fullPattern, '') === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid regex pattern'
                ], 422);
            }

            // Find matches
            $matches = [];
            $matchCount = preg_match_all($fullPattern, $text, $matches);

            // Extract detailed match information
            $detailedMatches = [];
            if ($matchCount > 0) {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $detailedMatches[] = [
                        'match' => $matches[0][$i],
                        'offset' => strpos($text, $matches[0][$i]),
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'pattern' => $pattern,
                    'match_count' => $matchCount,
                    'matches' => $detailedMatches,
                    'test_result' => $matchCount > 0 ? 'Matches found' : 'No matches',
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
            'pattern' => 'required|string|max:1000',
            'text' => 'required|string|max:50000',
            'modifiers' => 'string|max:10',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'regex-tester';
    }
}
