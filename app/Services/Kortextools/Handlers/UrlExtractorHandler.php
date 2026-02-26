<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlExtractorHandler implements ToolHandlerInterface
{
    /**
     * Handle URL extraction
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

            // Find all URLs
            $pattern = '#\bhttps?://[^\s<>"{}|\\^`\[\]]*#i';
            preg_match_all($pattern, $text, $matches);

            $urls = array_unique($matches[0]);
            $urls = array_values($urls); // Re-index array

            return response()->json([
                'success' => true,
                'data' => [
                    'urls' => $urls,
                    'count' => count($urls),
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
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'url-extractor';
    }
}
