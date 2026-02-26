<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PdfToExcelHandler implements ToolHandlerInterface
{
    /**
     * Handle PDF to Excel conversion
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
            $file = $request->file('file');

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded'
                ], 400);
            }

            $extension = strtolower($file->getClientOriginalExtension());

            if ($extension !== 'pdf') {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload a valid PDF file'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'PDF to Excel conversion feature is under development. Please try again later.',
                'data' => [
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $this->formatBytes($file->getSize()),
                    'file_type' => $extension,
                    'status' => 'queued_for_processing'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }

    public function getValidationRules()
    {
        return [
            'file' => 'required|file|mimes:pdf|max:20480',
        ];
    }

    public function getTemplate()
    {
        return 'pdf-to-excel';
    }
}
