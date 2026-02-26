<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageConverterHandler implements ToolHandlerInterface
{
    /**
     * Handle image format conversion
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
            $file = $request->file('image');
            $outputFormat = $request->input('output_format', 'jpg');

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'No image uploaded'
                ], 400);
            }

            $allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'];
            $inputExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($inputExtension, $allowedTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload a valid image file (JPG, PNG, WebP, GIF, BMP)'
                ], 400);
            }

            // For now, return a development message
            // In production, you would use GD, ImageMagick, or similar libraries
            return response()->json([
                'success' => true,
                'message' => 'Image conversion feature is under development. Please try again later.',
                'data' => [
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $this->formatBytes($file->getSize()),
                    'input_format' => $inputExtension,
                    'output_format' => $outputFormat,
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
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif,bmp|max:10240',
            'output_format' => 'required|string|in:jpg,png,webp,gif,bmp',
        ];
    }

    public function getTemplate()
    {
        return 'image-converter';
    }
}
