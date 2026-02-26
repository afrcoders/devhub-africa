<?php

namespace App\Services\Kortextools\Handlers;

class JsonValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $json = $data['json'] ?? '';

        try {
            json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            return [
                'success' => true,
                'is_valid' => true,
                'message' => 'Valid JSON',
                'formatted' => $this->formatJson($json),
            ];
        } catch (\JsonException $e) {
            return [
                'success' => false,
                'is_valid' => false,
                'error' => $e->getMessage(),
                'error_line' => $e->getLine(),
            ];
        }
    }

    private function formatJson(string $json): string
    {
        $decoded = json_decode($json, true);
        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function getValidationRules(): array
    {
        return [
            'json' => 'required|string',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.json-validator';
    }
}
