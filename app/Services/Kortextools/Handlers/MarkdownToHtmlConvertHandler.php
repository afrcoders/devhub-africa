<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class MarkdownToHtmlConvertHandler implements ToolHandlerInterface
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
