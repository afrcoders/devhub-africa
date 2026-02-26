<?php

namespace App\Services\Kortextools\Handlers;

class TorqueConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $value = floatval($data['value'] ?? 0);
        $conversionType = $data['conversion_type'] ?? 'nm-to-ftlb';

        $result = 0;
        $unit_from = '';
        $unit_to = '';

        switch ($conversionType) {
            case 'nm-to-ftlb':
                $result = $value * 0.737562;
                $unit_from = 'N·m';
                $unit_to = 'ft·lb';
                break;
            case 'ftlb-to-nm':
                $result = $value / 0.737562;
                $unit_from = 'ft·lb';
                $unit_to = 'N·m';
                break;
            case 'nm-to-inlb':
                $result = $value * 8.85075;
                $unit_from = 'N·m';
                $unit_to = 'in·lb';
                break;
            case 'inlb-to-nm':
                $result = $value / 8.85075;
                $unit_from = 'in·lb';
                $unit_to = 'N·m';
                break;
            case 'kgfm-to-nm':
                $result = $value * 9.80665;
                $unit_from = 'kgf·m';
                $unit_to = 'N·m';
                break;
            case 'nm-to-kgfm':
                $result = $value / 9.80665;
                $unit_from = 'N·m';
                $unit_to = 'kgf·m';
                break;
            case 'ftlb-to-inlb':
                $result = $value * 12;
                $unit_from = 'ft·lb';
                $unit_to = 'in·lb';
                break;
            case 'inlb-to-ftlb':
                $result = $value / 12;
                $unit_from = 'in·lb';
                $unit_to = 'ft·lb';
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
            'conversion_type' => 'required|string|in:nm-to-ftlb,ftlb-to-nm,nm-to-inlb,inlb-to-nm,kgfm-to-nm,nm-to-kgfm,ftlb-to-inlb,inlb-to-ftlb',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.torque-converter';
    }
}
