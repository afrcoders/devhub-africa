<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QrCodeGeneratorHandler implements ToolHandlerInterface
{
    /**
     * Handle QR code generation
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
            $text = $request->input('text');
            $size = $request->input('size', '300');
            $margin = $request->input('margin', '10');
            $errorCorrection = $request->input('error_correction', 'M');
            $format = $request->input('format', 'PNG');

            // Generate QR code URL using Google Charts API (simple implementation)
            $qrUrl = $this->generateQrCodeUrl($text, $size, $errorCorrection);

            return response()->json([
                'success' => true,
                'data' => [
                    'text' => $text,
                    'qr_code_url' => $qrUrl,
                    'size' => $size,
                    'margin' => $margin,
                    'error_correction' => $errorCorrection,
                    'format' => $format,
                    'download_instructions' => 'Right-click the QR code and save the image'
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
     * Generate QR code URL using Google Charts API
     */
    private function generateQrCodeUrl($text, $size, $errorCorrection)
    {
        $encodedText = urlencode($text);
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&ecc={$errorCorrection}&data={$encodedText}";
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'text' => 'required|string|max:2000',
            'size' => 'nullable|integer|min:100|max:1000',
            'margin' => 'nullable|integer|min:0|max:50',
            'error_correction' => 'nullable|string|in:L,M,Q,H',
            'format' => 'nullable|string|in:PNG,JPG,SVG',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'qrcode';
    }
}
