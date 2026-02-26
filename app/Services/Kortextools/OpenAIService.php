<?php

namespace App\Services\Kortextools;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Generate text completion using OpenAI
     */
    public function generateText($prompt, $maxTokens = 1000, $model = 'gpt-3.5-turbo')
    {
        if (!$this->apiKey) {
            throw new \Exception('OpenAI API key not configured');
        }

        // For development/testing purposes, return a mock response to avoid API costs
        if (app()->environment(['local', 'testing'])) {
            return $this->getMockResponse($prompt);
        }

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(60)
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                Log::error('OpenAI API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('OpenAI API request failed: ' . $response->body());
            }

            $data = $response->json();

            return $data['choices'][0]['message']['content'] ?? '';

        } catch (\Exception $e) {
            Log::error('OpenAI service error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get mock response for development/testing
     */
    private function getMockResponse($prompt)
    {
        if (str_contains($prompt, 'paraphrase')) {
            return "Here is a rephrased version of your text with improved clarity and varied sentence structure while maintaining the original meaning.";
        } elseif (str_contains($prompt, 'rewrite')) {
            return "This article has been completely rewritten with enhanced readability, better flow, and updated phrasing while preserving all key information and core messages.";
        } elseif (str_contains($prompt, 'meta description')) {
            return "SEO-optimized meta description that summarizes your content effectively for search engines and users.";
        } elseif (str_contains($prompt, 'hashtag')) {
            return "#productivity #tools #digitalmarketing #webtools #seotools #contentcreation #efficiency #online #business #technology";
        } else {
            return "Generated content based on your input using AI language processing.";
        }
    }

    /**
     * Paraphrase text
     */
    public function paraphraseText($text)
    {
        $prompt = "Please paraphrase the following text while maintaining its meaning and context. Make it unique and natural-sounding:\n\n" . $text;
        return $this->generateText($prompt, 2000);
    }

    /**
     * Rewrite article
     */
    public function rewriteArticle($text)
    {
        $prompt = "Please rewrite this article completely while maintaining the key information and message. Make it unique, engaging, and well-structured:\n\n" . $text;
        return $this->generateText($prompt, 3000);
    }

    /**
     * Generate meta description
     */
    public function generateMetaDescription($content, $maxLength = 160)
    {
        $prompt = "Create an SEO-optimized meta description (max {$maxLength} characters) for the following content:\n\n" . substr($content, 0, 1000);
        return $this->generateText($prompt, 100);
    }

    /**
     * Generate hashtags
     */
    public function generateHashtags($content, $count = 10)
    {
        $prompt = "Generate {$count} relevant hashtags for the following content. Return only the hashtags, separated by spaces:\n\n" . substr($content, 0, 1000);
        return $this->generateText($prompt, 200);
    }

    /**
     * Check if OpenAI is available
     */
    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }
}
