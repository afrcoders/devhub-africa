<?php

namespace App\Services\Kortextools\Handlers;

class Base64EncoderDecoderHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $operation = $data['operation'] ?? 'encode';

        try {
            if ($operation === 'encode') {
                $result = base64_encode($text);
                $message = 'Encoded successfully';
            } else {
                // Try to decode
                $result = base64_decode($text, true);
                if ($result === false) {
                    return [
                        'success' => false,
                        'error' => 'Invalid Base64 format',
                    ];
                }
                $message = 'Decoded successfully';
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
        return 'africoders.kortextools.tools.base64-encoder-decoder';
    }
}
