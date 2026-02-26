<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class SslCheckerHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $domain = $data['domain'] ?? '';

        if (empty($domain)) {
            return [
                'success' => false,
                'error' => 'Domain is required'
            ];
        }

        // Remove protocol if present
        $domain = preg_replace('/^https?:\/\//', '', $domain);
        $domain = preg_replace('/\/.*$/', '', $domain);

        try {
            $sslInfo = $this->getSslInfo($domain);

            return [
                'success' => true,
                'domain' => $domain,
                'ssl_info' => $sslInfo
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Could not retrieve SSL information: ' . $e->getMessage()
            ];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'domain' => 'required|string|max:255'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.ssl-checker';
    }

    private function getSslInfo($domain)
    {
        $context = stream_context_create([
            "ssl" => [
                "capture_peer_cert" => true,
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "timeout" => 10
            ]
        ]);

        $stream = @stream_socket_client(
            "ssl://{$domain}:443",
            $errno,
            $errstr,
            10,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$stream) {
            throw new \Exception("Unable to connect to {$domain}:443. {$errstr}");
        }

        $params = stream_context_get_params($stream);
        $cert = $params['options']['ssl']['peer_certificate'];

        if (!$cert) {
            throw new \Exception("No SSL certificate found");
        }

        $certData = openssl_x509_parse($cert);

        if (!$certData) {
            throw new \Exception("Unable to parse SSL certificate");
        }

        $validFrom = date('Y-m-d H:i:s', $certData['validFrom_time_t']);
        $validTo = date('Y-m-d H:i:s', $certData['validTo_time_t']);
        $daysUntilExpiry = ceil(($certData['validTo_time_t'] - time()) / 86400);
        $isValid = $certData['validTo_time_t'] > time() && $certData['validFrom_time_t'] < time();

        return [
            'issuer' => $certData['issuer']['CN'] ?? 'Unknown',
            'subject' => $certData['subject']['CN'] ?? 'Unknown',
            'valid_from' => $validFrom,
            'valid_to' => $validTo,
            'days_until_expiry' => $daysUntilExpiry,
            'is_valid' => $isValid,
            'signature_algorithm' => $certData['signatureTypeSN'] ?? 'Unknown',
            'serial_number' => $certData['serialNumberHex'] ?? 'Unknown',
            'version' => $certData['version'] ?? 'Unknown'
        ];
    }
}
