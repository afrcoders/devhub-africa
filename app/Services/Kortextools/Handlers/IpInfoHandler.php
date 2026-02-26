<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;

class IpInfoHandler implements ToolHandlerInterface
{
    /**
     * Handle IP info lookup
     */
    public function handle(Request $request)
    {
        try {
            // Get client IP
            $ip = $this->getClientIp($request);

            // Check if IP is valid
            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid IP address'
                ], 422);
            }

            // Determine IP version
            $ipVersion = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? 'IPv4' : 'IPv6';

            // Check if private IP
            $isPrivate = $this->isPrivateIp($ip);

            return response()->json([
                'success' => true,
                'data' => [
                    'ip' => $ip,
                    'version' => $ipVersion,
                    'is_private' => $isPrivate,
                    'is_public' => !$isPrivate,
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
        return [];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'ip-info';
    }

    /**
     * Get client IP address
     */
    protected function getClientIp($request)
    {
        if ($request->has('ip')) {
            return $request->input('ip');
        }

        // Get from request
        $ip = $request->ip();
        return $ip ?: 'Unknown';
    }

    /**
     * Check if IP is private
     */
    protected function isPrivateIp($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) === false;
    }
}
