<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JpgToPdfHandler implements ToolHandlerInterface
{
    /**
     * Handle JPG to PDF conversion
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
            $files = $request->file('images');

            if (!$files || count($files) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No images uploaded'
                ], 400);
            }

            $processedImages = [];
            foreach ($files as $file) {
                $allowedTypes = ['jpg', 'jpeg'];
                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, $allowedTypes)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please upload only JPG/JPEG images'
                    ], 400);
                }

                $processedImages[] = [
                    'name' => $file->getClientOriginalName(),
                    'size' => $this->formatBytes($file->getSize()),
                    'type' => $extension
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'JPG to PDF conversion feature is under development. Please try again later.',
                'data' => [
                    'images_count' => count($processedImages),
                    'images' => $processedImages,
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
            'images.*' => 'required|image|mimes:jpg,jpeg|max:10240', // 10MB per image
        ];
    }

    public function getTemplate()
    {
        return 'jpg-to-pdf';
    }
}
