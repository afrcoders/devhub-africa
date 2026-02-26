<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

/**
 * Generic handler for tools that are UI-only or placeholder
 * Maps tool slug to appropriate view
 */
class GenericToolHandler implements ToolHandlerInterface
{
    protected $toolSlug;

    public function __construct($toolSlug = '')
    {
        $this->toolSlug = $toolSlug;
    }

    public function handle(array $data): array
    {
        $toolSlug = $data['tool_slug'] ?? $this->toolSlug;

        return [
            'success' => true,
            'tool' => $toolSlug,
            'status' => 'Tool interface ready',
            'message' => 'Use the web interface to interact with this tool',
            'data' => $data
        ];
    }

    public function getValidationRules(): array
    {
        return ['input' => 'nullable|string'];
    }

    public function getTemplate(): string
    {
        return "africoders.kortextools.tools.{$this->toolSlug}";
    }
}

// Specific handlers for remaining tools
class PingToolHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $host = trim($data['host'] ?? '');
        if (empty($host)) return ['success' => false, 'error' => 'Host required'];

        try {
            $cmd = "ping -c 4 " . escapeshellarg($host);
            @exec($cmd, $output, $code);
            return ['success' => $code === 0, 'host' => $host, 'reachable' => $code === 0, 'output' => implode("\n", $output)];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getValidationRules(): array
    {
        return ['host' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.ping-tool';
    }
}

class CsvToJsonHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $csv = $data['csv'] ?? '';
        if (empty($csv)) return ['success' => false, 'error' => 'CSV required'];

        try {
            $lines = array_filter(explode("\n", trim($csv)));
            if (count($lines) < 2) return ['success' => false, 'error' => 'CSV needs headers'];

            $headers = str_getcsv(array_shift($lines));
            $result = [];
            foreach ($lines as $line) {
                $values = str_getcsv($line);
                if (count($values) === count($headers)) {
                    $result[] = array_combine($headers, $values);
                }
            }
            return ['success' => true, 'result' => json_encode($result, JSON_PRETTY_PRINT), 'rows' => count($result)];
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

class JsonToCsvHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $json = $data['json'] ?? '';
        try {
            $array = json_decode($json, true);
            if (!is_array($array) || empty($array)) throw new \Exception('Invalid JSON array');

            $csv = '';
            $headers = array_keys($array[0]);
            $csv .= implode(',', $headers) . "\n";

            foreach ($array as $row) {
                $values = [];
                foreach ($headers as $header) {
                    $values[] = '"' . str_replace('"', '""', $row[$header] ?? '') . '"';
                }
                $csv .= implode(',', $values) . "\n";
            }

            return ['success' => true, 'result' => trim($csv), 'rows' => count($array)];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getValidationRules(): array
    {
        return ['json' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.json-to-csv';
    }
}

class BmiCalcHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $weight = floatval($data['weight'] ?? 0);
        $height = floatval($data['height'] ?? 0);
        $unit = $data['unit'] ?? 'metric';

        if ($weight <= 0 || $height <= 0) return ['success' => false, 'error' => 'Invalid input'];

        $bmi = $unit === 'metric' ? $weight / ($height * $height) : ($weight / ($height * $height)) * 703;
        $category = $bmi < 18.5 ? 'Underweight' : ($bmi < 25 ? 'Normal' : ($bmi < 30 ? 'Overweight' : 'Obese'));

        return ['success' => true, 'bmi' => round($bmi, 1), 'category' => $category];
    }

    public function getValidationRules(): array
    {
        return ['weight' => 'required|numeric|gt:0', 'height' => 'required|numeric|gt:0', 'unit' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.bmi-calculator';
    }
}

class AgeCalcHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $birthDate = $data['birth_date'] ?? '';
        try {
            $birth = new \DateTime($birthDate);
            $today = new \DateTime();
            $age = $today->diff($birth);
            return ['success' => true, 'years' => $age->y, 'months' => $age->m, 'days' => $age->d];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Invalid date'];
        }
    }

    public function getValidationRules(): array
    {
        return ['birth_date' => 'required|date'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.age-calculator';
    }
}

class Md5HashGenHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        return ['success' => true, 'result' => md5($text)];
    }

    public function getValidationRules(): array
    {
        return ['text' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.md5-hash';
    }
}

class Sha256HashGenHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        return ['success' => true, 'result' => hash('sha256', $text)];
    }

    public function getValidationRules(): array
    {
        return ['text' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.sha256-hash';
    }
}

class HmacGenHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $key = $data['key'] ?? '';
        return ['success' => true, 'result' => hash_hmac('sha256', $text, $key)];
    }

    public function getValidationRules(): array
    {
        return ['text' => 'required|string', 'key' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.hmac-generator';
    }
}

class SlugGenHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $text), '-'));
        return ['success' => true, 'result' => $slug];
    }

    public function getValidationRules(): array
    {
        return ['text' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.slug-generator';
    }
}

class ReverseTextHandlerImpl implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        return ['success' => true, 'result' => strrev($data['text'] ?? '')];
    }

    public function getValidationRules(): array
    {
        return ['text' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.reverse-text';
    }
}

class RegexTestHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $pattern = $data['pattern'] ?? '';
        $text = $data['text'] ?? '';

        try {
            $matches = [];
            preg_match_all($pattern, $text, $matches);
            return ['success' => true, 'matches' => $matches[0] ?? [], 'count' => count($matches[0] ?? [])];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Invalid regex'];
        }
    }

    public function getValidationRules(): array
    {
        return ['pattern' => 'required|string', 'text' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.regex-tester';
    }
}

class RgbToHexHandlerImpl implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $r = intval($data['r'] ?? 0);
        $g = intval($data['g'] ?? 0);
        $b = intval($data['b'] ?? 0);

        if ($r < 0 || $r > 255 || $g < 0 || $g > 255 || $b < 0 || $b > 255) {
            return ['success' => false, 'error' => 'RGB values must be 0-255'];
        }

        $hex = '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
        return ['success' => true, 'result' => strtoupper($hex)];
    }

    public function getValidationRules(): array
    {
        return ['r' => 'required|integer|min:0|max:255', 'g' => 'required|integer|min:0|max:255', 'b' => 'required|integer|min:0|max:255'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.rgb-to-hex';
    }
}

class HexToRgbHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $hex = str_replace('#', '', $data['hex'] ?? '');

        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
            return ['success' => false, 'error' => 'Invalid hex color'];
        }

        return ['success' => true, 'r' => hexdec(substr($hex, 0, 2)), 'g' => hexdec(substr($hex, 2, 2)), 'b' => hexdec(substr($hex, 4, 2))];
    }

    public function getValidationRules(): array
    {
        return ['hex' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.hex-to-rgb';
    }
}

class UtmBuilderHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $baseUrl = $data['base_url'] ?? '';
        $params = array_filter(['utm_source' => $data['source'] ?? '', 'utm_medium' => $data['medium'] ?? '', 'utm_campaign' => $data['campaign'] ?? '']);
        $fullUrl = $baseUrl . '?' . http_build_query($params);
        return ['success' => true, 'result' => $fullUrl];
    }

    public function getValidationRules(): array
    {
        return ['base_url' => 'required|url', 'source' => 'required|string', 'medium' => 'required|string', 'campaign' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.utm-builder';
    }
}
