<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use App\Models\KortexTool;
use App\Services\Kortextools\OpenAIService;

class RewriteArticleHandler implements ToolHandlerInterface
{
    protected $tool;
    protected $openAI;

    public function __construct($tool = null)
    {
        $this->tool = $tool;
        $this->openAI = new OpenAIService();
    }

    /**
     * Handle the tool request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function handle(Request $request)
    {
        // Get tool from database if not provided
        if (!$this->tool) {
            $slug = $request->route('slug');
            $this->tool = KortexTool::where('slug', $slug)->first();

            if (!$this->tool) {
                abort(404, 'Tool not found');
            }
        }

        // If this is a GET request, show the tool interface
        if ($request->isMethod('get')) {
            $templatePath = 'africoders.kortextools.tools.' . $this->tool->slug;

            if (!view()->exists($templatePath)) {
                return view('africoders.kortextools.coming-soon', [
                    'tool' => $this->tool,
                    'message' => 'This tool is under development and will be available soon.'
                ]);
            }

            return view($templatePath, ['tool' => $this->tool]);
        }

        // Check if OpenAI is available
        if (!$this->openAI->isAvailable()) {
            return response()->json([
                'status' => 'error',
                'message' => 'AI service is not available. Please configure OpenAI API key.'
            ], 503);
        }

        // Handle POST request for processing
        $text = $request->input('text', '');

        if (empty(trim($text))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Article content is required'
            ], 400);
        }

        if (strlen($text) > 10000) {
            return response()->json([
                'status' => 'error',
                'message' => 'Article is too long. Maximum 10000 characters allowed.'
            ], 400);
        }

        try {
            $rewritten = $this->openAI->rewriteArticle($text);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'original' => $text,
                    'rewritten' => $rewritten,
                    'original_word_count' => str_word_count($text),
                    'rewritten_word_count' => str_word_count($rewritten),
                    'readability_improvement' => 'Article has been rewritten for better clarity and engagement.'
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Article rewriting error: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error rewriting article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getValidationRules(): array
    {
        return [
            'text' => 'required|string|max:10000',
        ];
    }

    public function getTemplate(): string
    {
        if ($this->tool) {
            return 'africoders.kortextools.tools.' . $this->tool->slug;
        }
        return 'africoders.kortextools.coming-soon';
    }
}
