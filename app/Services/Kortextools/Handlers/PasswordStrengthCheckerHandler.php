<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasswordStrengthCheckerHandler implements ToolHandlerInterface
{
    /**
     * Handle password strength check
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
            $password = $request->input('password');

            $strength = $this->checkStrength($password);
            $feedback = $this->getFeedback($password, $strength);

            return response()->json([
                'success' => true,
                'data' => [
                    'password_length' => strlen($password),
                    'strength' => $strength['score'],
                    'strength_text' => $strength['text'],
                    'strength_color' => $strength['color'],
                    'has_lowercase' => preg_match('/[a-z]/', $password),
                    'has_uppercase' => preg_match('/[A-Z]/', $password),
                    'has_numbers' => preg_match('/\d/', $password),
                    'has_special' => preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password),
                    'feedback' => $feedback,
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
     * Check password strength
     */
    private function checkStrength($password)
    {
        $score = 0;

        // Length scoring
        if (strlen($password) >= 8) $score++;
        if (strlen($password) >= 12) $score++;
        if (strlen($password) >= 16) $score++;

        // Character variety
        if (preg_match('/[a-z]/', $password)) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/\d/', $password)) $score++;
        if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) $score++;

        // Very weak
        if ($score <= 2) {
            return ['score' => 1, 'text' => 'Very Weak', 'color' => 'danger'];
        }
        // Weak
        elseif ($score <= 4) {
            return ['score' => 2, 'text' => 'Weak', 'color' => 'warning'];
        }
        // Fair
        elseif ($score <= 6) {
            return ['score' => 3, 'text' => 'Fair', 'color' => 'info'];
        }
        // Good
        elseif ($score <= 8) {
            return ['score' => 4, 'text' => 'Good', 'color' => 'success'];
        }
        // Strong
        else {
            return ['score' => 5, 'text' => 'Strong', 'color' => 'success'];
        }
    }

    /**
     * Get feedback for password
     */
    private function getFeedback($password, $strength)
    {
        $feedback = [];

        if (strlen($password) < 8) {
            $feedback[] = 'Password should be at least 8 characters long';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $feedback[] = 'Add lowercase letters';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $feedback[] = 'Add uppercase letters';
        }

        if (!preg_match('/\d/', $password)) {
            $feedback[] = 'Add numbers';
        }

        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            $feedback[] = 'Add special characters';
        }

        if (empty($feedback)) {
            $feedback[] = 'Great! Your password is strong.';
        }

        return $feedback;
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'password' => 'required|string|min:1|max:1000',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'password-strength-checker';
    }
}
