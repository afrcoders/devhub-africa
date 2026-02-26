<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HashGeneratorHandler implements ToolHandlerInterface
{
    /**
     * Handle hash generation
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
            $algorithm = $request->input('algorithm', 'md5');

            $hashes = [];

            // Always generate common hashes
            $hashes['md5'] = md5($text);
            $hashes['sha1'] = sha1($text);
            $hashes['sha256'] = hash('sha256', $text);
            $hashes['sha512'] = hash('sha512', $text);
            $hashes['crc32'] = hash('crc32', $text);

            return response()->json([
                'success' => true,
                'data' => [
                    'input' => $text,
                    'hashes' => $hashes,
                    'length' => strlen($text),
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
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'text' => 'required|string|max:50000',
            'algorithm' => 'in:md5,sha1,sha256,sha512,crc32',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'hash-generator';
    }
}
