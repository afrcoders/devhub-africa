<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class DomainValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $domain = $data['domain'] ?? '';
        
        $isValid = $this->validateDomain($domain);
        $components = $this->extractDomainComponents($domain);

        return [
            'success' => true,
            'is_valid' => $isValid,
            'domain' => $domain,
            'components' => $components,
            'message' => $isValid ? 'Valid domain' : 'Invalid domain format'
        ];
    }

    private function validateDomain($domain): bool
    {
        if (empty($domain) || strlen($domain) > 253) {
            return false;
        }

        $pattern = '/^(?!-)[a-zA-Z0-9-]{1,63}(?<!-)(\.[a-zA-Z0-9-]{1,63})*\.[a-zA-Z]{2,}$/';
        return (bool) preg_match($pattern, $domain);
    }

    private function extractDomainComponents($domain): array
    {
        $parts = explode('.', $domain);
        return [
            'subdomain' => count($parts) > 2 ? implode('.', array_slice($parts, 0, -2)) : null,
            'name' => count($parts) > 0 ? $parts[-2] ?? $parts[0] : null,
            'tld' => count($parts) > 0 ? end($parts) : null,
            'parts_count' => count($parts)
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'domain' => 'required|string|max:253',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.domain-validator';
    }
}
