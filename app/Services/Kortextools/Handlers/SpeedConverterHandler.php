<?php

namespace App\Services\Kortextools\Handlers;

class SpeedConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'kmh-to-mph';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'kmh-to-mph':
                $result = $value * 0.621371;
                $unit_from = 'km/h';
                $unit_to = 'mph';
                break;
            case 'mph-to-kmh':
                $result = $value / 0.621371;
                $unit_from = 'mph';
                $unit_to = 'km/h';
                break;
            case 'kmh-to-mps':
                $result = $value / 3.6;
                $unit_from = 'km/h';
                $unit_to = 'm/s';
                break;
            case 'mps-to-kmh':
                $result = $value * 3.6;
                $unit_from = 'm/s';
                $unit_to = 'km/h';
                break;
            case 'knots-to-kmh':
                $result = $value * 1.852;
                $unit_from = 'knots';
                $unit_to = 'km/h';
                break;
            case 'kmh-to-knots':
                $result = $value / 1.852;
                $unit_from = 'km/h';
                $unit_to = 'knots';
                break;
            case 'mps-to-mph':
                $result = $value * 2.237;
                $unit_from = 'm/s';
                $unit_to = 'mph';
                break;
            case 'mph-to-mps':
                $result = $value / 2.237;
                $unit_from = 'mph';
                $unit_to = 'm/s';
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
            'conversion_type' => 'required|string|in:kmh-to-mph,mph-to-kmh,kmh-to-mps,mps-to-kmh,knots-to-kmh,kmh-to-knots,mps-to-mph,mph-to-mps',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.speed-converter';
    }
}
