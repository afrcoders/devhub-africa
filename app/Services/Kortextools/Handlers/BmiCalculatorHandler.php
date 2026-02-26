<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class BmiCalculatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $weight = floatval($data['weight'] ?? 0);
        $height = floatval($data['height'] ?? 0);
        $unit = $data['unit'] ?? 'metric';

        if ($weight <= 0 || $height <= 0) {
            return ['success' => false, 'error' => 'Invalid weight or height'];
        }

        $bmi = $unit === 'metric' ? $weight / ($height * $height) : ($weight / ($height * $height)) * 703;
        $category = $this->getBmiCategory($bmi);

        return [
            'success' => true,
            'bmi' => round($bmi, 1),
            'category' => $category,
            'description' => $this->getCategoryDescription($category)
        ];
    }

    private function getBmiCategory($bmi): string
    {
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal weight';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }

    private function getCategoryDescription($category): string
    {
        return match($category) {
            'Underweight' => 'May need to gain weight',
            'Normal weight' => 'Healthy weight range',
            'Overweight' => 'May need to lose weight',
            'Obese' => 'Should consult a doctor',
            default => ''
        };
    }

    public function getValidationRules(): array
    {
        return [
            'weight' => 'required|numeric|gt:0',
            'height' => 'required|numeric|gt:0',
            'unit' => 'required|string|in:metric,imperial'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.bmi-calculator';
    }
}
