<?php

namespace App\Services\Kortextools\Handlers;

class PressureConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'pa-to-atm';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'pa-to-atm':
                $result = $value / 101325;
                $unit_from = 'Pa';
                $unit_to = 'atm';
                break;
            case 'atm-to-pa':
                $result = $value * 101325;
                $unit_from = 'atm';
                $unit_to = 'Pa';
                break;
            case 'bar-to-pa':
                $result = $value * 100000;
                $unit_from = 'bar';
                $unit_to = 'Pa';
                break;
            case 'pa-to-bar':
                $result = $value / 100000;
                $unit_from = 'Pa';
                $unit_to = 'bar';
                break;
            case 'psi-to-pa':
                $result = $value * 6894.76;
                $unit_from = 'psi';
                $unit_to = 'Pa';
                break;
            case 'pa-to-psi':
                $result = $value / 6894.76;
                $unit_from = 'Pa';
                $unit_to = 'psi';
                break;
            case 'mmhg-to-pa':
                $result = $value * 133.322;
                $unit_from = 'mmHg';
                $unit_to = 'Pa';
                break;
            case 'pa-to-mmhg':
                $result = $value / 133.322;
                $unit_from = 'Pa';
                $unit_to = 'mmHg';
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
            'conversion_type' => 'required|string|in:pa-to-atm,atm-to-pa,bar-to-pa,pa-to-bar,psi-to-pa,pa-to-psi,mmhg-to-pa,pa-to-mmhg',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.pressure-converter';
    }
}
