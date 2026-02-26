<?php

namespace App\Services\Kortextools\Handlers;

class UrlEncoderDecoderHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $operation = $data['operation'] ?? 'encode';

        try {
            if ($operation === 'encode') {
                $result = rawurlencode($text);
                $message = 'URL encoded successfully';
            } else {
                $result = rawurldecode($text);
                $message = 'URL decoded successfully';
            }

            return [
                'success' => true,
                'result' => $result,
                'original' => $text,
                'operation' => $operation,
                'message' => $message,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'text' => 'required|string',
            'operation' => 'required|string|in:encode,decode',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.url-encoder-decoder';
    }
}
