<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use App\Models\KortexTool;

class PasswordGeneratorHandler implements ToolHandlerInterface
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
        $length = intval($request->input('length', 16));
        $includeUppercase = filter_var($request->input('include_uppercase', true), FILTER_VALIDATE_BOOLEAN);
        $includeLowercase = filter_var($request->input('include_lowercase', true), FILTER_VALIDATE_BOOLEAN);
        $includeNumbers = filter_var($request->input('include_numbers', true), FILTER_VALIDATE_BOOLEAN);
        $includeSpecial = filter_var($request->input('include_special', true), FILTER_VALIDATE_BOOLEAN);

        // Validate length
        if ($length < 4 || $length > 128) {
            $length = 16;
        }

        $characters = '';
        if ($includeLowercase) $characters .= 'abcdefghijklmnopqrstuvwxyz';
        if ($includeUppercase) $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($includeNumbers) $characters .= '0123456789';
        if ($includeSpecial) $characters .= '!@#$%^&*()_+-=[]{}|;:,.<>?';

        if (empty($characters)) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        }

        $password = '';
        $charLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $charLength - 1)];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'password' => $password,
                'length' => $length,
                'strength' => $this->calculateStrength($password),
            ]
        ]);
    }

    private function calculateStrength(string $password): string
    {
        $score = 0;
        if (strlen($password) >= 8) $score++;
        if (strlen($password) >= 12) $score++;
        if (preg_match('/[a-z]/', $password)) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/[0-9]/', $password)) $score++;
        if (preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/', $password)) $score++;

        return match ($score) {
            0, 1 => 'Very Weak',
            2, 3 => 'Weak',
            4 => 'Fair',
            5 => 'Good',
            6 => 'Very Strong',
            default => 'Excellent',
        };
    }

    public function getValidationRules(): array
    {
        return [
            'length' => 'integer|min:4|max:128',
            'include_uppercase' => 'boolean',
            'include_lowercase' => 'boolean',
            'include_numbers' => 'boolean',
            'include_special' => 'boolean',
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
