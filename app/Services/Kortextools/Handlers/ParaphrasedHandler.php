<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use App\Models\KortexTool;
use App\Services\Kortextools\OpenAIService;

class ParaphrasedHandler implements ToolHandlerInterface
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
                'message' => 'Text content is required'
            ], 400);
        }

        if (strlen($text) > 5000) {
            return response()->json([
                'status' => 'error',
                'message' => 'Text is too long. Maximum 5000 characters allowed.'
            ], 400);
        }

        try {
            $paraphrased = $this->openAI->paraphraseText($text);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'original' => $text,
                    'paraphrased' => $paraphrased,
                    'original_word_count' => str_word_count($text),
                    'paraphrased_word_count' => str_word_count($paraphrased),
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Paraphrasing error: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error paraphrasing text: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getValidationRules(): array
    {
        return [
            'text' => 'required|string|max:5000',
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
