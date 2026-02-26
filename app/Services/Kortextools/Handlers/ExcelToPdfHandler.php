<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExcelToPdfHandler implements ToolHandlerInterface
{
    /**
     * Handle Excel to PDF conversion
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

            $allowedExtensions = ['xls', 'xlsx'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload a valid Excel spreadsheet (.xls or .xlsx file)'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Excel to PDF conversion feature is under development. Please try again later.',
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
            'file' => 'required|file|mimes:xls,xlsx|max:20480',
        ];
    }

    public function getTemplate()
    {
        return 'excel-to-pdf';
    }
}
