<?php

namespace App\Services\Kortextools\Handlers;

class VolumeConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'liter-to-gallon';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'liter-to-gallon':
                $result = $value * 0.264172;
                $unit_from = 'L';
                $unit_to = 'gal';
                break;
            case 'gallon-to-liter':
                $result = $value / 0.264172;
                $unit_from = 'gal';
                $unit_to = 'L';
                break;
            case 'liter-to-ml':
                $result = $value * 1000;
                $unit_from = 'L';
                $unit_to = 'mL';
                break;
            case 'ml-to-liter':
                $result = $value / 1000;
                $unit_from = 'mL';
                $unit_to = 'L';
                break;
            case 'cubicm-to-liter':
                $result = $value * 1000;
                $unit_from = 'm³';
                $unit_to = 'L';
                break;
            case 'liter-to-cubicm':
                $result = $value / 1000;
                $unit_from = 'L';
                $unit_to = 'm³';
                break;
            case 'pint-to-liter':
                $result = $value * 0.473176;
                $unit_from = 'pints';
                $unit_to = 'L';
                break;
            case 'liter-to-pint':
                $result = $value / 0.473176;
                $unit_from = 'L';
                $unit_to = 'pints';
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
            'conversion_type' => 'required|string|in:liter-to-gallon,gallon-to-liter,liter-to-ml,ml-to-liter,cubicm-to-liter,liter-to-cubicm,pint-to-liter,liter-to-pint',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.volume-converter';
    }
}
