<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WordToPdfHandler implements ToolHandlerInterface
{
    /**
     * Handle Word to PDF conversion
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

            // Validate file type
            $allowedExtensions = ['doc', 'docx'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload a valid Word document (.doc or .docx file)'
                ], 400);
            }

            // For now, return a message indicating the feature is under development
            // In production, you would use libraries like phpoffice/phpword or call external APIs
            return response()->json([
                'success' => true,
                'message' => 'Word to PDF conversion feature is under development. Please try again later.',
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

    /**
     * Format file size in human readable format
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'file' => 'required|file|mimes:doc,docx|max:20480', // 20MB max
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'word-to-pdf';
    }
}
