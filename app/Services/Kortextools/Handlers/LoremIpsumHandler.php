<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoremIpsumHandler implements ToolHandlerInterface
{
    private $words = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing',
        'elit', 'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore',
        'et', 'dolore', 'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam',
        'quis', 'nostrud', 'exercitation', 'ullamco', 'laboris', 'nisi',
        'aliquip', 'ex', 'ea', 'commodo', 'consequat', 'duis', 'aute', 'irure',
        'in', 'reprehenderit', 'voluptate', 'velit', 'esse', 'cillum', 'fugiat',
        'nulla', 'pariatur', 'excepteur', 'sint', 'occaecat', 'cupidatat',
        'non', 'proident', 'sunt', 'culpa', 'qui', 'officia', 'deserunt',
        'mollit', 'anim', 'id', 'est', 'laborum',
    ];

    /**
     * Handle Lorem Ipsum generation
     */
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $type = $request->input('type', 'paragraphs');
            $count = (int) $request->input('count', 3);

            // Validate count
            if ($count < 1 || $count > 100) {
                $count = 3;
            }

            $text = match ($type) {
                'words' => $this->generateWords($count),
                'sentences' => $this->generateSentences($count),
                'paragraphs' => $this->generateParagraphs($count),
                default => $this->generateParagraphs($count),
            };

            return response()->json([
                'success' => true,
                'data' => [
                    'text' => $text,
                    'type' => $type,
                    'count' => $count,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Lorem Ipsum words
     */
    private function generateWords($count)
    {
        $words = [];
        for ($i = 0; $i < $count; $i++) {
            $words[] = $this->words[array_rand($this->words)];
        }
        return implode(' ', $words);
    }

    /**
     * Generate Lorem Ipsum sentences
     */
    private function generateSentences($count)
    {
        $sentences = [];
        for ($i = 0; $i < $count; $i++) {
            $wordCount = rand(5, 15);
            $words = [];
            for ($j = 0; $j < $wordCount; $j++) {
                $words[] = $this->words[array_rand($this->words)];
            }
            $sentence = ucfirst(implode(' ', $words)) . '.';
            $sentences[] = $sentence;
        }
        return implode(' ', $sentences);
    }

    /**
     * Generate Lorem Ipsum paragraphs
     */
    private function generateParagraphs($count)
    {
        $paragraphs = [];
        for ($i = 0; $i < $count; $i++) {
            $sentenceCount = rand(4, 7);
            $sentences = [];
            for ($j = 0; $j < $sentenceCount; $j++) {
                $wordCount = rand(5, 15);
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

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'type' => 'required|in:words,sentences,paragraphs',
            'count' => 'required|integer|min:1|max:100',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'lorem-ipsum';
    }
}
