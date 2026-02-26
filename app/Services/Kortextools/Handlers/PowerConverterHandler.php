<?php

namespace App\Services\Kortextools\Handlers;

class PowerConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'watt-to-kw';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'watt-to-kw':
                $result = $value / 1000;
                $unit_from = 'W';
                $unit_to = 'kW';
                break;
            case 'kw-to-watt':
                $result = $value * 1000;
                $unit_from = 'kW';
                $unit_to = 'W';
                break;
            case 'watt-to-hp':
                $result = $value * 0.00134102;
                $unit_from = 'W';
                $unit_to = 'hp';
                break;
            case 'hp-to-watt':
                $result = $value / 0.00134102;
                $unit_from = 'hp';
                $unit_to = 'W';
                break;
            case 'kw-to-hp':
                $result = $value * 1.34102;
                $unit_from = 'kW';
                $unit_to = 'hp';
                break;
            case 'hp-to-kw':
                $result = $value / 1.34102;
                $unit_from = 'hp';
                $unit_to = 'kW';
                break;
            case 'btu-to-watt':
                $result = $value * 0.293071;
                $unit_from = 'BTU/h';
                $unit_to = 'W';
                break;
            case 'watt-to-btu':
                $result = $value / 0.293071;
                $unit_from = 'W';
                $unit_to = 'BTU/h';
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
            'conversion_type' => 'required|string|in:watt-to-kw,kw-to-watt,watt-to-hp,hp-to-watt,kw-to-hp,hp-to-kw,btu-to-watt,watt-to-btu',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.power-converter';
    }
}
