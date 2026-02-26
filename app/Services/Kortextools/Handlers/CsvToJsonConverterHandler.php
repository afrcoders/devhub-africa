<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class CsvToJsonConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $csv = $data['csv'] ?? '';
        if (empty($csv)) {
            return ['success' => false, 'error' => 'CSV data is required'];
        }

        try {
            $lines = array_filter(explode("\n", trim($csv)));
            if (count($lines) < 2) {
                return ['success' => false, 'error' => 'CSV must have at least a header row'];
            }

            $headers = str_getcsv(array_shift($lines));
            $data = [];

            foreach ($lines as $line) {
                $values = str_getcsv($line);
                if (count($values) === count($headers)) {
                    $data[] = array_combine($headers, $values);
                }
            }

            return [
                'success' => true,
                'result' => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'rows' => count($data)
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getValidationRules(): array
    {
        return ['csv' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.csv-to-json';
    }
}
