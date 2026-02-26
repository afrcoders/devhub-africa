<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use App\Models\KortexTool;

class CharacterCounterHandler implements ToolHandlerInterface
{
    protected $tool;

    public function __construct($tool = null)
    {
        $this->tool = $tool;
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

        // Handle POST request for processing
        $text = $request->input('text', '');

        $result = [
            'characters' => mb_strlen($text),
            'characters_no_spaces' => mb_strlen(str_replace(' ', '', $text)),
            'words' => str_word_count($text),
            'lines' => substr_count($text, "\n") + 1,
            'paragraphs' => count(array_filter(preg_split('/\n\s*\n/', $text))),
            'bytes' => strlen($text),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }

    /**
     * Get validation rules for tool input
     *
     * @return array
     */
    public function getValidationRules()
    {
        return [
            'text' => 'required|string|max:100000',
        ];
    }

    /**
     * Get tool template name
     *
     * @return string
     */
    public function getTemplate()
    {
        if ($this->tool) {
            return 'africoders.kortextools.tools.' . $this->tool->slug;
        }
        return 'africoders.kortextools.coming-soon';
    }
}
