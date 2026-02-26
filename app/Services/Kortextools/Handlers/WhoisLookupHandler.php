<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhoisLookupHandler implements ToolHandlerInterface
{
    /**
     * Handle WHOIS lookup
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
            $query = $request->input('query');

            // Validate domain/IP format
            if (!$this->isValidDomainOrIp($query)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid domain or IP address format',
                ], 422);
            }

            // For demo, return simulated WHOIS data
            // In production, use whois.php library or shell_exec('whois ...')
            $whoisData = $this->getSimulatedWhois($query);

            return response()->json([
                'success' => true,
                'data' => [
                    'query' => $query,
                    'whois' => $whoisData,
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
     * Validate domain or IP
     */
    private function isValidDomainOrIp($query)
    {
        // Check if IP
        if (filter_var($query, FILTER_VALIDATE_IP)) {
            return true;
        }

        // Check if domain
        if (filter_var($query, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return true;
        }

        return false;
    }

    /**
     * Get simulated WHOIS data
     */
    private function getSimulatedWhois($query)
    {
        $isIp = filter_var($query, FILTER_VALIDATE_IP);

        if ($isIp) {
            return "Domain Name: {$query}\n"
                . "IP Version: " . (filter_var($query, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'IPv6' : 'IPv4') . "\n"
                . "Organization: Network Information Center\n"
                . "Country: US\n"
                . "Status: Active\n\n"
                . "Note: For full WHOIS data, install whois.php library or use shell_exec('whois ...')";
        }

        return "Domain Name: {$query}\n"
            . "Registrar: Example Registrar\n"
            . "Registrant Country: US\n"
            . "Admin Email: admin@example.com\n"
            . "Created Date: 2020-01-01\n"
            . "Updated Date: 2024-01-01\n"
            . "Expires Date: 2025-01-01\n\n"
            . "Note: For full WHOIS data, install whois.php library or use shell_exec('whois ...')";
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'query' => 'required|string|max:255',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'whois-lookup';
    }
}
