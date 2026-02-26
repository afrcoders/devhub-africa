<?php

namespace App\Services\Kortextools\Handlers;

class LengthConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'meter-to-feet';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'meter-to-feet':
                $result = $value * 3.28084;
                $unit_from = 'm';
                $unit_to = 'ft';
                break;
            case 'feet-to-meter':
                $result = $value / 3.28084;
                $unit_from = 'ft';
                $unit_to = 'm';
                break;
            case 'meter-to-cm':
                $result = $value * 100;
                $unit_from = 'm';
                $unit_to = 'cm';
                break;
            case 'cm-to-meter':
                $result = $value / 100;
                $unit_from = 'cm';
                $unit_to = 'm';
                break;
            case 'km-to-miles':
                $result = $value * 0.621371;
                $unit_from = 'km';
                $unit_to = 'miles';
                break;
            case 'miles-to-km':
                $result = $value / 0.621371;
                $unit_from = 'miles';
                $unit_to = 'km';
                break;
            case 'inch-to-cm':
                $result = $value * 2.54;
                $unit_from = 'inches';
                $unit_to = 'cm';
                break;
            case 'cm-to-inch':
                $result = $value / 2.54;
                $unit_from = 'cm';
                $unit_to = 'inches';
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
            'conversion_type' => 'required|string|in:meter-to-feet,feet-to-meter,meter-to-cm,cm-to-meter,km-to-miles,miles-to-km,inch-to-cm,cm-to-inch',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.length-converter';
    }
}
