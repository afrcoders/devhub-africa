<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountCalculatorHandler implements ToolHandlerInterface
{
    /**
     * Handle discount calculation
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
            $originalPrice = (float) $request->input('original_price');
            $discountPercent = (float) $request->input('discount_percent');

            $discountAmount = ($originalPrice * $discountPercent) / 100;
            $finalPrice = $originalPrice - $discountAmount;
            $savings = $discountAmount;

            return response()->json([
                'success' => true,
                'data' => [
                    'original_price' => round($originalPrice, 2),
                    'discount_percent' => $discountPercent,
                    'discount_amount' => round($discountAmount, 2),
                    'final_price' => round($finalPrice, 2),
                    'you_save' => round($savings, 2),
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
            'original_price' => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'discount-calculator';
    }
}
