<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class IpAddressValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $ip = trim($data['ip'] ?? '');
        $version = $data['version'] ?? 'both';

        $isValidIPv4 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        $isValidIPv6 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        $isValid = false;
        $ipVersion = null;

        if ($version === 'both' || $version === 'ipv4') {
            if ($isValidIPv4) {
                $isValid = true;
                $ipVersion = 'IPv4';
            }
        }

        if ($version === 'both' || $version === 'ipv6') {
            if ($isValidIPv6) {
                $isValid = true;
                $ipVersion = 'IPv6';
            }
        }

        $info = $isValid ? $this->getIpInfo($ip, $ipVersion) : null;

        return [
            'success' => true,
            'is_valid' => $isValid,
            'ip' => $ip,
            'version' => $ipVersion,
            'info' => $info,
            'message' => $isValid ? "Valid {$ipVersion} address" : 'Invalid IP address'
        ];
    }

    private function getIpInfo($ip, $version): array
    {
        if ($version === 'IPv4') {
            return [
                'is_private' => $this->isPrivateIPv4($ip),
                'is_loopback' => $ip === '127.0.0.1',
                'binary' => implode('.', array_map(fn($octet) => decbin($octet), explode('.', $ip))),
            ];
        }

        return [
            'is_loopback' => $ip === '::1',
            'compressed' => inet_ntop(inet_pton($ip)),
        ];
    }

    private function isPrivateIPv4($ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE) === false;
    }

    public function getValidationRules(): array
    {
        return [
            'ip' => 'required|string',
            'version' => 'required|string|in:both,ipv4,ipv6',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.ip-validator';
    }
}
