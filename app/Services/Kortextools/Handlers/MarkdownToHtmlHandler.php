<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarkdownToHtmlHandler implements ToolHandlerInterface
{
    /**
     * Handle Markdown to HTML conversion
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
            $markdown = $request->input('markdown');

            $html = $this->parseMarkdown($markdown);

            return response()->json([
                'success' => true,
                'data' => [
                    'html' => $html,
                    'length' => strlen($html),
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
            'markdown' => 'required|string|max:50000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'markdown-to-html';
    }

    /**
     * Simple markdown parser
     */
    protected function parseMarkdown($text)
    {
        // Escape HTML
        $text = htmlspecialchars($text);

        // Headers
        $text = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $text);

        // Bold
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__(.+?)__/', '<strong>$1</strong>', $text);

        // Italic
        $text = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.+?)_/', '<em>$1</em>', $text);

        // Code
        $text = preg_replace('/`(.+?)`/', '<code>$1</code>', $text);

        // Links
        $text = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $text);

        // Line breaks
        $text = str_replace("\n", "<br>\n", $text);

        // Paragraphs
        $text = '<p>' . str_replace('<br>' . "\n<br>", '</p><p>', $text) . '</p>';

        return $text;
    }
}
