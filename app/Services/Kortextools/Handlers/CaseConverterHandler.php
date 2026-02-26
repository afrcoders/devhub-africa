<?php

namespace App\Services\Kortextools\Handlers;

class CaseConverterHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $caseType = $data['case_type'] ?? 'uppercase';

        $result = match ($caseType) {
            'uppercase' => strtoupper($text),
            'lowercase' => strtolower($text),
            'capitalize' => ucwords(strtolower($text)),
            'title-case' => ucwords($text),
            'sentence-case' => ucfirst($text),
            'toggle-case' => $this->toggleCase($text),
            'camel-case' => $this->camelCase($text),
            'snake-case' => $this->snakeCase($text),
            'kebab-case' => $this->kebabCase($text),
            default => $text,
        };

        return [
            'success' => true,
            'result' => $result,
            'original' => $text,
            'case_type' => $caseType,
        ];
    }

    private function toggleCase(string $text): string
    {
        $result = '';
        foreach (str_split($text) as $char) {
            $result .= ctype_upper($char) ? strtolower($char) : strtoupper($char);
        }
        return $result;
    }

    private function camelCase(string $text): string
    {
        $words = preg_split('/[\s_-]+/', strtolower(trim($text)), -1, PREG_SPLIT_NO_EMPTY);
        if (empty($words)) return '';
        return $words[0] . implode('', array_map('ucfirst', array_slice($words, 1)));
    }

    private function snakeCase(string $text): string
    {
        $text = preg_replace('/([a-z])([A-Z])/', '$1_$2', $text);
        return strtolower(preg_replace('/[\s-]+/', '_', trim($text)));
    }

    private function kebabCase(string $text): string
    {
        $text = preg_replace('/([a-z])([A-Z])/', '$1-$2', $text);
        return strtolower(preg_replace('/[\s_]+/', '-', trim($text)));
    }

    public function getValidationRules(): array
    {
        return [
            'text' => 'required|string',
            'case_type' => 'required|string|in:uppercase,lowercase,capitalize,title-case,sentence-case,toggle-case,camel-case,snake-case,kebab-case',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.case-converter';
    }
}
