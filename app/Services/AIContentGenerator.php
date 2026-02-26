<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIContentGenerator
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Generate discussion content
     */
    public function generateDiscussion(string $category): array
    {
        $prompt = "Generate a realistic discussion post for an African tech community forum in the '{$category}' category. Return JSON with 'title' (under 100 chars) and 'body' (200-400 words) keys. Focus on relevant African tech topics, challenges, or opportunities.";

        return $this->generate($prompt);
    }

    /**
     * Generate a reply to a discussion
     */
    public function generateReply(string $discussionTitle, string $discussionBody): string
    {
        $prompt = "Generate a helpful, thoughtful reply (100-200 words) to this discussion:\n\nTitle: {$discussionTitle}\n\nBody: {$discussionBody}\n\nProvide practical advice or insights from an African tech professional perspective.";

        $response = $this->generate($prompt, false);
        return $response['content'] ?? 'Thank you for sharing this. This is an important topic for our community.';
    }

    /**
     * Generate business listing content
     */
    public function generateBusinessListing(): array
    {
        $prompt = "Generate a realistic African business listing for a tech/innovation company. Return JSON with 'name', 'description' (150-250 words), 'category' (one of: Technology, E-commerce, FinTech, AgriTech, EdTech, HealthTech, Logistics), 'country' (African country), 'city' (major city in that country), and 'tagline' (under 100 chars) keys.";

        return $this->generate($prompt);
    }

    /**
     * Generate course review
     */
    public function generateCourseReview(string $courseTitle): array
    {
        $prompt = "Generate a realistic course review for '{$courseTitle}'. Return JSON with 'rating' (3-5), 'comment' (100-200 words focusing on practical value) keys.";

        return $this->generate($prompt);
    }

    /**
     * Main generation method
     */
    protected function generate(string $prompt, bool $expectJson = true): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl . '/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $expectJson
                            ? 'You are a helpful assistant that generates realistic content for an African tech ecosystem. Always respond with valid JSON only, no additional text.'
                            : 'You are a helpful assistant generating realistic content for an African tech community.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.8,
                'max_tokens' => 800,
            ]);

            if (!$response->successful()) {
                \Log::error('OpenAI API Error', ['response' => $response->body()]);
                return $this->getFallbackContent($prompt);
            }

            $content = $response->json()['choices'][0]['message']['content'] ?? '';

            if ($expectJson) {
                // Clean up the response - remove markdown code blocks if present
                $content = preg_replace('/```json\s*|\s*```/', '', $content);
                $content = trim($content);

                $decoded = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    \Log::error('JSON Decode Error', ['content' => $content, 'error' => json_last_error_msg()]);
                    return $this->getFallbackContent($prompt);
                }
                return $decoded;
            }

            return ['content' => $content];

        } catch (\Exception $e) {
            \Log::error('AI Generation Error', ['error' => $e->getMessage()]);
            return $this->getFallbackContent($prompt);
        }
    }

    /**
     * Fallback content when AI fails
     */
    protected function getFallbackContent(string $prompt): array
    {
        if (str_contains($prompt, 'discussion')) {
            return [
                'title' => 'Exploring Opportunities in African Tech',
                'body' => 'I wanted to start a conversation about the growing opportunities in the African tech ecosystem. From fintech innovations to e-commerce solutions, there\'s so much potential across the continent. What are your thoughts on the most promising sectors for tech growth in Africa?'
            ];
        }

        if (str_contains($prompt, 'business listing')) {
            return [
                'name' => 'TechHub Africa',
                'description' => 'TechHub Africa is a leading technology innovation company focused on providing cutting-edge solutions for African businesses. We specialize in digital transformation, cloud services, and software development.',
                'category' => 'Technology',
                'country' => 'Nigeria',
                'city' => 'Lagos',
                'tagline' => 'Innovating Africa\'s Digital Future'
            ];
        }

        if (str_contains($prompt, 'review')) {
            return [
                'rating' => 4,
                'comment' => 'Great course with practical examples. The instructor explains concepts clearly and the content is relevant to real-world scenarios.'
            ];
        }

        return ['content' => 'Interesting topic. Looking forward to more discussions on this.'];
    }
}
