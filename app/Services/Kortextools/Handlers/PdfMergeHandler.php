<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser as PdfParser;
use setasign\Fpdi\Fpdi;

class PdfMergeHandler implements ToolHandlerInterface
{
    /**
     * Handle PDF merge processing
     */
    public function handle(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Get uploaded files - try both 'files' and 'pdfs'
            $files = $request->file('files') ?? $request->file('pdfs');
            if (!is_array($files)) {
                $files = [$files];
            }

            if (count($files) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload at least 2 PDF files to merge',
                ], 422);
            }

            // Create FPDI instance for merging
            $pdf = new Fpdi();

            // Add all PDF files
            foreach ($files as $file) {
                $tempPath = $file->store('temp-pdfs');
                $fullPath = storage_path('app/' . $tempPath);

                try {
                    // Get page count
                    $pageCount = $pdf->setSourceFile($fullPath);

                    // Add all pages from this PDF
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $pageId = $pdf->importPage($i);
                        $size = $pdf->getImportedPageSize($pageId);

                        $pdf->AddPage($size['orientation'], $size['size']);
                        $pdf->useImportedPage($pageId);
                    }

                    // Clean up temp file
                    @unlink($fullPath);
                } catch (\Exception $e) {
                    // Clean up on error
                    @unlink($fullPath);
                    throw $e;
                }
            }

            // Generate output
            $filename = 'merged-' . time() . '.pdf';
            $pdf->Output(storage_path('app/temp-pdfs/' . $filename), 'F');

            return response()->download(
                storage_path('app/temp-pdfs/' . $filename),
                $filename,
                [
                    'Content-Type' => 'application/pdf',
                ]
            )->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error merging PDFs: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'files' => 'required|array|min:2',
            'files.*' => 'required|file|mimes:pdf|max:50000', // 50MB per file
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'pdf-merge';
    }
}
