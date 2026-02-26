<?php

namespace App\Services\Kortextools\Handlers;

class LoremIpsumGeneratorHandler implements ToolHandlerInterface
{
    private array $words = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
        'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore',
        'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud',
        'exercitation', 'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo',
        'consequat', 'duis', 'aute', 'irure', 'in', 'reprehenderit', 'voluptate',
        'velit', 'esse', 'cillum', 'fugiat', 'nulla', 'pariatur', 'excepteur', 'sint',
        'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa', 'qui', 'officia',
        'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum'
    ];

    public function handle(array $data): array
    {
        $type = $data['type'] ?? 'paragraphs';
        $count = intval($data['count'] ?? 1);

        if ($count < 1) $count = 1;
        if ($count > 50) $count = 50;

        $result = '';

        switch ($type) {
            case 'words':
                $result = $this->generateWords($count);
                break;
            case 'sentences':
                $result = $this->generateSentences($count);
                break;
            case 'paragraphs':
            default:
                $result = $this->generateParagraphs($count);
                break;
        }

        return [
            'success' => true,
            'text' => $result,
            'type' => $type,
            'count' => $count,
        ];
    }

    private function generateWords(int $count): string
    {
        $words = [];
        for ($i = 0; $i < $count; $i++) {
            $words[] = $this->words[array_rand($this->words)];
        }
        return implode(' ', $words);
    }

    private function generateSentences(int $count): string
    {
        $sentences = [];
        for ($i = 0; $i < $count; $i++) {
            $wordCount = random_int(5, 15);
            $words = [];
            for ($j = 0; $j < $wordCount; $j++) {
                $words[] = $this->words[array_rand($this->words)];
            }
            $sentence = ucfirst(implode(' ', $words)) . '.';
            $sentences[] = $sentence;
        }
        return implode(' ', $sentences);
    }

    private function generateParagraphs(int $count): string
    {
        $paragraphs = [];
        for ($i = 0; $i < $count; $i++) {
            $sentenceCount = random_int(4, 8);
            $sentences = [];
            for ($j = 0; $j < $sentenceCount; $j++) {
                $wordCount = random_int(5, 15);
                $words = [];
                for ($k = 0; $k < $wordCount; $k++) {
                    $words[] = $this->words[array_rand($this->words)];
                }
                $sentence = ucfirst(implode(' ', $words)) . '.';
                $sentences[] = $sentence;
            }
            $paragraphs[] = implode(' ', $sentences);
        }
        return implode("\n\n", $paragraphs);
    }

    public function getValidationRules(): array
    {
        return [
            'type' => 'string|in:words,sentences,paragraphs',
            'count' => 'integer|min:1|max:50',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.lorem-ipsum-generator';
    }
}
