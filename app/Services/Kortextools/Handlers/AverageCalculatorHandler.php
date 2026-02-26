<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AverageCalculatorHandler implements ToolHandlerInterface
{
    /**
     * Handle average calculation
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
            $values = array_map('floatval', explode(',', $request->input('numbers')));
            $values = array_filter(array_map('trim', $values), fn($v) => $v !== '');

            if (empty($values)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter at least one number'
                ], 422);
            }

            $average = array_sum($values) / count($values);
            $median = $this->calculateMedian($values);
            $mode = $this->calculateMode($values);

            return response()->json([
                'success' => true,
                'data' => [
                    'count' => count($values),
                    'sum' => round(array_sum($values), 2),
                    'average' => round($average, 2),
                    'median' => round($median, 2),
                    'mode' => $mode,
                    'min' => round(min($values), 2),
                    'max' => round(max($values), 2),
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
     * Calculate median
     */
    private function calculateMedian($values)
    {
        sort($values);
        $count = count($values);
        $middle = intval($count / 2);

        if ($count % 2 == 1) {
            return $values[$middle];
        }

        return ($values[$middle - 1] + $values[$middle]) / 2;
    }

    /**
     * Calculate mode
     */
    private function calculateMode($values)
    {
        $valueCount = array_count_values($values);
        $maxCount = max($valueCount);
        $modes = array_keys($valueCount, $maxCount);

        return count($modes) == count($values) ? 'No mode' : implode(', ', $modes);
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'numbers' => 'required|string',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'average-calculator';
    }
}
