<?php

namespace App\Services\Kortextools\Handlers;

class WeightConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'kg-to-lbs';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'kg-to-lbs':
                $result = $value * 2.20462;
                $unit_from = 'kg';
                $unit_to = 'lbs';
                break;
            case 'lbs-to-kg':
                $result = $value / 2.20462;
                $unit_from = 'lbs';
                $unit_to = 'kg';
                break;
            case 'kg-to-g':
                $result = $value * 1000;
                $unit_from = 'kg';
                $unit_to = 'g';
                break;
            case 'g-to-kg':
                $result = $value / 1000;
                $unit_from = 'g';
                $unit_to = 'kg';
                break;
            case 'oz-to-g':
                $result = $value * 28.3495;
                $unit_from = 'oz';
                $unit_to = 'g';
                break;
            case 'g-to-oz':
                $result = $value / 28.3495;
                $unit_from = 'g';
                $unit_to = 'oz';
                break;
            case 'ton-to-kg':
                $result = $value * 1000;
                $unit_from = 'metric ton';
                $unit_to = 'kg';
                break;
            case 'kg-to-ton':
                $result = $value / 1000;
                $unit_from = 'kg';
                $unit_to = 'metric ton';
                break;
        }

        return [
            'success' => true,
            'result' => round($result, 2),
            'original_value' => $value,
            'unit_from' => $unit_from,
            'unit_to' => $unit_to,
            'conversion_type' => $conversionType,
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'value' => 'required|numeric',
            'conversion_type' => 'required|string|in:kg-to-lbs,lbs-to-kg,kg-to-g,g-to-kg,oz-to-g,g-to-oz,ton-to-kg,kg-to-ton',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.weight-converter';
    }
}
