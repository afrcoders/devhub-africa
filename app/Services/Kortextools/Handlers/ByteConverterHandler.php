<?php

namespace App\Services\Kortextools\Handlers;

class ByteConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'byte-to-kb';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'byte-to-kb':
                $result = $value / 1024;
                $unit_from = 'B';
                $unit_to = 'KB';
                break;
            case 'kb-to-byte':
                $result = $value * 1024;
                $unit_from = 'KB';
                $unit_to = 'B';
                break;
            case 'kb-to-mb':
                $result = $value / 1024;
                $unit_from = 'KB';
                $unit_to = 'MB';
                break;
            case 'mb-to-kb':
                $result = $value * 1024;
                $unit_from = 'MB';
                $unit_to = 'KB';
                break;
            case 'mb-to-gb':
                $result = $value / 1024;
                $unit_from = 'MB';
                $unit_to = 'GB';
                break;
            case 'gb-to-mb':
                $result = $value * 1024;
                $unit_from = 'GB';
                $unit_to = 'MB';
                break;
            case 'gb-to-tb':
                $result = $value / 1024;
                $unit_from = 'GB';
                $unit_to = 'TB';
                break;
            case 'tb-to-gb':
                $result = $value * 1024;
                $unit_from = 'TB';
                $unit_to = 'GB';
                break;
            case 'byte-to-mb':
                $result = $value / (1024 * 1024);
                $unit_from = 'B';
                $unit_to = 'MB';
                break;
            case 'byte-to-gb':
                $result = $value / (1024 * 1024 * 1024);
                $unit_from = 'B';
                $unit_to = 'GB';
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
            'conversion_type' => 'required|string|in:byte-to-kb,kb-to-byte,kb-to-mb,mb-to-kb,mb-to-gb,gb-to-mb,gb-to-tb,tb-to-gb,byte-to-mb,byte-to-gb',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.byte-converter';
    }
}
