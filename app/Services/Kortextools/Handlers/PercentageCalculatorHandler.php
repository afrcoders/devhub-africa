<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PercentageCalculatorHandler implements ToolHandlerInterface
{
    /**
     * Handle percentage calculations
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
            $operation = $request->input('operation');
            $value1 = (float) $request->input('value1');
            $value2 = (float) $request->input('value2');

            $result = match ($operation) {
                'percentage' => $this->calculatePercentage($value1, $value2),
                'percentage_increase' => $this->percentageIncrease($value1, $value2),
                'percentage_decrease' => $this->percentageDecrease($value1, $value2),
                'percentage_of' => $this->percentageOf($value1, $value2),
                default => null,
            };

            return response()->json([
                'success' => true,
                'data' => [
                    'operation' => $operation,
                    'value1' => $value1,
                    'value2' => $value2,
                    'result' => round($result, 2),
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
     * Calculate what percentage value1 is of value2
     */
    private function calculatePercentage($value1, $value2)
    {
        return $value2 == 0 ? 0 : ($value1 / $value2) * 100;
    }

    /**
     * Calculate percentage increase
     */
    private function percentageIncrease($original, $new)
    {
        return $original == 0 ? 0 : (($new - $original) / $original) * 100;
    }

    /**
     * Calculate percentage decrease
     */
    private function percentageDecrease($original, $new)
    {
        return $original == 0 ? 0 : (($original - $new) / $original) * 100;
    }

    /**
     * Calculate percentage of a value
     */
    private function percentageOf($percentage, $total)
    {
        return ($percentage / 100) * $total;
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'operation' => 'required|in:percentage,percentage_increase,percentage_decrease,percentage_of',
            'value1' => 'required|numeric',
            'value2' => 'required|numeric',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'percentage-calculator';
    }
}
