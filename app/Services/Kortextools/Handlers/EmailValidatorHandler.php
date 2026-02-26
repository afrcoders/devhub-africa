<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailValidatorHandler implements ToolHandlerInterface
{
    /**
     * Handle email validation
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
            $email = $request->input('email');

            $isValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            $parts = explode('@', $email);

            return response()->json([
                'success' => true,
                'data' => [
                    'email' => $email,
                    'is_valid' => $isValid,
                    'local_part' => $parts[0] ?? '',
                    'domain' => $parts[1] ?? '',
                    'feedback' => $this->getFeedback($email, $isValid),
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
     * Get validation feedback
     */
    private function getFeedback($email, $isValid)
    {
        $feedback = [];

        if (!$isValid) {
            $feedback[] = 'This email address is not valid';
        } else {
            $feedback[] = 'This email address is valid';
        }

        if (strlen($email) > 254) {
            $feedback[] = 'Email is longer than 254 characters';
        }

        if (strpos($email, '..') !== false) {
            $feedback[] = 'Email contains consecutive dots';
        }

        if (substr($email, 0, 1) === '.' || substr($email, -1) === '.') {
            $feedback[] = 'Email starts or ends with a dot';
        }

        return $feedback;
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'email' => 'required|string|max:254',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'email-validator';
    }
}
