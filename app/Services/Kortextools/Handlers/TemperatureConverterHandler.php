<?php

namespace App\Services\Kortextools\Handlers;

class TemperatureConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'celsius-to-fahrenheit';

        $result = 0;
        $formula = '';

        switch ($conversionType) {
            case 'celsius-to-fahrenheit':
                $result = ($value * 9/5) + 32;
                $formula = '(°C × 9/5) + 32 = °F';
                break;
            case 'fahrenheit-to-celsius':
                $result = ($value - 32) * 5/9;
                $formula = '(°F - 32) × 5/9 = °C';
                break;
            case 'celsius-to-kelvin':
                $result = $value + 273.15;
                $formula = '°C + 273.15 = K';
                break;
            case 'kelvin-to-celsius':
                $result = $value - 273.15;
                $formula = 'K - 273.15 = °C';
                break;
            case 'fahrenheit-to-kelvin':
                $result = ($value - 32) * 5/9 + 273.15;
                $formula = '(°F - 32) × 5/9 + 273.15 = K';
                break;
            case 'kelvin-to-fahrenheit':
                $result = ($value - 273.15) * 9/5 + 32;
                $formula = '(K - 273.15) × 9/5 + 32 = °F';
                break;
        }

        return [
            'success' => true,
            'result' => round($result, 2),
            'formula' => $formula,
            'original_value' => $value,
            'conversion_type' => $conversionType,
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'value' => 'required|numeric',
            'conversion_type' => 'required|string|in:celsius-to-fahrenheit,fahrenheit-to-celsius,celsius-to-kelvin,kelvin-to-celsius,fahrenheit-to-kelvin,kelvin-to-fahrenheit',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.temperature-converter';
    }
}
