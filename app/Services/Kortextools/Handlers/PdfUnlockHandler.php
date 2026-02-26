<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class PdfUnlockHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        return [
            'success' => true,
            'result' => 'PDF Unlock requires file uploads. This is a demonstration tool.',
            'note' => 'In production, use mPDF or TCPDF library with decryption',
            'status' => 'File upload form available in web interface'
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'pdf_file' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.pdf-unlock';
    }
}
