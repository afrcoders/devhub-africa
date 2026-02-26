<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use App\Models\KortexTool;

class JsonFormatterHandler implements ToolHandlerInterface
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
        $json = $request->input('json', '');
        $format_type = $request->input('format_type', 'pretty');

        if (empty(trim($json))) {
            return response()->json([
                'status' => 'error',
                'message' => 'JSON content is empty'
            ], 400);
        }

        try {
            $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            $result = match ($format_type) {
                'pretty' => json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'minify' => json_encode($decoded, JSON_UNESCAPED_SLASHES),
                'compact' => json_encode($decoded),
                default => json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            };

            return response()->json([
                'status' => 'success',
                'data' => [
                    'result' => $result,
                    'original' => $json,
                    'format_type' => $format_type,
                    'original_size' => strlen($json),
                    'result_size' => strlen($result),
                ]
            ]);

        } catch (\JsonException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid JSON: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getValidationRules(): array
    {
        return [
            'json' => 'required|string|max:1000000',
            'format_type' => 'string|in:pretty,minify,compact',
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
