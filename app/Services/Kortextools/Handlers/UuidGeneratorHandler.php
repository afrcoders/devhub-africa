<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;

class UuidGeneratorHandler implements ToolHandlerInterface
{
    /**
     * Handle UUID generation
     */
    public function handle(Request $request)
    {
        try {
            $count = max(1, min(100, (int)($request->input('count', 1))));
            $version = $request->input('version', 'v4');

            $uuids = [];
            for ($i = 0; $i < $count; $i++) {
                $uuids[] = $this->generateUuid($version);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'uuids' => $uuids,
                    'count' => count($uuids),
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
            'count' => 'integer|min:1|max:100',
            'version' => 'in:v1,v3,v4,v5',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'uuid-generator';
    }

    /**
     * Generate UUID v4 (random)
     */
    protected function generateUuid($version = 'v4')
    {
        if ($version === 'v4') {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }

        // For other versions, default to v4
        return $this->generateUuid('v4');
    }
}
