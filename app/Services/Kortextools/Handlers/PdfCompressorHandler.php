<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class PdfCompressorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        return [
            'success' => true,
            'result' => 'PDF Compressor requires file uploads. This is a demonstration tool.',
            'note' => 'In production, use mPDF or TCPDF library with compression settings',
            'status' => 'File upload form available in web interface'
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'pdf_file' => 'required|string',
            'compression_level' => 'required|string|in:low,medium,high',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.pdf-compressor';
    }
}
