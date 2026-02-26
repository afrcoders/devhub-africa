<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class ReverseTextHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        return ['success' => true, 'result' => strrev($text)];
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

class MarkdownToHtmlHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $markdown = $data['markdown'] ?? '';
        $html = $this->parseMarkdown($markdown);
        return ['success' => true, 'result' => $html];
    }

    private function parseMarkdown($text): string
    {
        $text = htmlspecialchars($text);
        $text = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $text);
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/\n/', '<br>', $text);
        return $text;
    }

    public function getValidationRules(): array
    {
        return ['markdown' => 'required|string'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.markdown-to-html';
    }
}

class SlugGeneratorHandler implements ToolHandlerInterface
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

class Md5HashHandler implements ToolHandlerInterface
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

class Sha256HashHandler implements ToolHandlerInterface
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

class HmacGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $key = $data['key'] ?? '';
        $result = hash_hmac('sha256', $text, $key);
        return ['success' => true, 'result' => $result];
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

class RegexTesterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $pattern = $data['pattern'] ?? '';
        $text = $data['text'] ?? '';

        try {
            $matches = [];
            preg_match_all($pattern, $text, $matches);
            return [
                'success' => true,
                'matches' => $matches[0] ?? [],
                'count' => count($matches[0] ?? []),
                'hasMatches' => count($matches[0] ?? []) > 0
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Invalid regex pattern'];
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

class UtmBuilderHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $baseUrl = $data['base_url'] ?? '';
        $source = $data['source'] ?? '';
        $medium = $data['medium'] ?? '';
        $campaign = $data['campaign'] ?? '';

        $params = array_filter(['utm_source' => $source, 'utm_medium' => $medium, 'utm_campaign' => $campaign]);
        $fullUrl = $baseUrl . '?' . http_build_query($params);

        return ['success' => true, 'result' => $fullUrl];
    }

    public function getValidationRules(): array
    {
        return [
            'base_url' => 'required|url',
            'source' => 'required|string',
            'medium' => 'required|string',
            'campaign' => 'required|string'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.utm-builder';
    }
}

class AgeCalculatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $birthDate = $data['birth_date'] ?? '';
        try {
            $birth = new \DateTime($birthDate);
            $today = new \DateTime();
            $age = $today->diff($birth);

            return [
                'success' => true,
                'years' => $age->y,
                'months' => $age->m,
                'days' => $age->d,
                'total_days' => $age->days
            ];
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
