<?php

namespace App\Services\Kortextools\Handlers;

class RandomNumberGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $min = intval($data['min'] ?? 1);
        $max = intval($data['max'] ?? 100);
        $count = intval($data['count'] ?? 1);

        // Validate inputs
        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }

        if ($count < 1 || $count > 100) {
            $count = 1;
        }

        $numbers = [];
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = random_int($min, $max);
        }

        return [
            'success' => true,
            'numbers' => $numbers,
            'min' => $min,
            'max' => $max,
            'count' => count($numbers),
            'average' => round(array_sum($numbers) / count($numbers), 2),
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'min' => 'required|integer',
            'max' => 'required|integer',
            'count' => 'integer|min:1|max:100',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.random-number-generator';
    }
}
