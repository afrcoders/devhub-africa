<?php

namespace App\Services\Kortextools\Handlers;

class AreaConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'sqm-to-sqft';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'sqm-to-sqft':
                $result = $value * 10.764;
                $unit_from = 'm²';
                $unit_to = 'ft²';
                break;
            case 'sqft-to-sqm':
                $result = $value / 10.764;
                $unit_from = 'ft²';
                $unit_to = 'm²';
                break;
            case 'sqm-to-hectare':
                $result = $value / 10000;
                $unit_from = 'm²';
                $unit_to = 'hectare';
                break;
            case 'hectare-to-sqm':
                $result = $value * 10000;
                $unit_from = 'hectare';
                $unit_to = 'm²';
                break;
            case 'sqkm-to-sqmile':
                $result = $value * 0.386102;
                $unit_from = 'km²';
                $unit_to = 'mi²';
                break;
            case 'sqmile-to-sqkm':
                $result = $value / 0.386102;
                $unit_from = 'mi²';
                $unit_to = 'km²';
                break;
            case 'acre-to-sqm':
                $result = $value * 4046.86;
                $unit_from = 'acres';
                $unit_to = 'm²';
                break;
            case 'sqm-to-acre':
                $result = $value / 4046.86;
                $unit_from = 'm²';
                $unit_to = 'acres';
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
            'conversion_type' => 'required|string|in:sqm-to-sqft,sqft-to-sqm,sqm-to-hectare,hectare-to-sqm,sqkm-to-sqmile,sqmile-to-sqkm,acre-to-sqm,sqm-to-acre',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.area-converter';
    }
}
