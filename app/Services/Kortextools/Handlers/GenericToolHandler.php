<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use App\Models\KortexTool;

/**
 * Generic Tool Handler
 *
 * This handler serves tools that don't require server-side processing
 * and only need to display their Blade template views.
 */
class GenericToolHandler implements ToolHandlerInterface
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
     * @return \Illuminate\View\View|\Illuminate\Http\Response
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

        // Check if the tool template exists
        $templatePath = 'africoders.kortextools.tools.' . $this->tool->slug;

        if (!view()->exists($templatePath)) {
            // Show coming soon page for tools without templates
            return view('africoders.kortextools.coming-soon', [
                'tool' => $this->tool,
                'message' => 'This tool is under development and will be available soon.'
            ]);
        }

        // Return the tool's view
        return view($templatePath, [
            'tool' => $this->tool
        ]);
    }

    /**
     * Get validation rules for tool input
     *
     * @return array
     */
    public function getValidationRules()
    {
        // Generic tools typically don't require server-side validation
        return [];
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
