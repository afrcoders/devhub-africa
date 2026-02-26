<?php

namespace App\Services\Kortextools\Handlers;

class TimeConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'second-to-minute';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'second-to-minute':
                $result = $value / 60;
                $unit_from = 'seconds';
                $unit_to = 'minutes';
                break;
            case 'minute-to-second':
                $result = $value * 60;
                $unit_from = 'minutes';
                $unit_to = 'seconds';
                break;
            case 'minute-to-hour':
                $result = $value / 60;
                $unit_from = 'minutes';
                $unit_to = 'hours';
                break;
            case 'hour-to-minute':
                $result = $value * 60;
                $unit_from = 'hours';
                $unit_to = 'minutes';
                break;
            case 'hour-to-day':
                $result = $value / 24;
                $unit_from = 'hours';
                $unit_to = 'days';
                break;
            case 'day-to-hour':
                $result = $value * 24;
                $unit_from = 'days';
                $unit_to = 'hours';
                break;
            case 'day-to-week':
                $result = $value / 7;
                $unit_from = 'days';
                $unit_to = 'weeks';
                break;
            case 'week-to-day':
                $result = $value * 7;
                $unit_from = 'weeks';
                $unit_to = 'days';
                break;
            case 'second-to-hour':
                $result = $value / 3600;
                $unit_from = 'seconds';
                $unit_to = 'hours';
                break;
            case 'millisecond-to-second':
                $result = $value / 1000;
                $unit_from = 'milliseconds';
                $unit_to = 'seconds';
                break;
        }

        return [
            'success' => true,
            'result' => round($result, 4),
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
            'conversion_type' => 'required|string|in:second-to-minute,minute-to-second,minute-to-hour,hour-to-minute,hour-to-day,day-to-hour,day-to-week,week-to-day,second-to-hour,millisecond-to-second',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.time-converter';
    }
}
