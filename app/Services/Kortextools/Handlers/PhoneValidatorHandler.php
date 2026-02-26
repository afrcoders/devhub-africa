<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class PhoneValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $phone = preg_replace('/[^\d+\-\s()]/', '', $data['phone'] ?? '');
        $country = strtoupper($data['country'] ?? 'US');

        $isValid = $this->validatePhone($phone, $country);
        $formatted = $this->formatPhone($phone, $country);

        return [
            'success' => true,
            'is_valid' => $isValid,
            'phone' => $phone,
            'country' => $country,
            'formatted' => $formatted,
            'message' => $isValid ? 'Valid phone number' : 'Invalid phone number for ' . $country
        ];
    }

    private function validatePhone($phone, $country): bool
    {
        // Basic validation patterns for common countries
        $patterns = [
            'US' => '/^\+?1?[-.\s]?\(?[0-9]{3}\)?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4}$/',
            'UK' => '/^\+?44?\s?[0-9]{10,11}$/',
            'CA' => '/^\+?1?[-.\s]?\(?[0-9]{3}\)?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4}$/',
            'AU' => '/^\+?61?[-.\s]?[0-9]{8,9}$/',
            'IN' => '/^\+?91?[-.\s]?[0-9]{10}$/',
            'FR' => '/^\+?33?[-.\s]?[0-9]{9}$/',
            'DE' => '/^\+?49?[-.\s]?[0-9]{9,11}$/',
        ];

        $pattern = $patterns[$country] ?? '/^\+?[0-9\s\-()]{10,}$/';
        return (bool) preg_match($pattern, $phone);
    }

    private function formatPhone($phone, $country): string
    {
        $digits = preg_replace('/[^\d]/', '', $phone);

        if ($country === 'US' && strlen($digits) === 10) {
            return '(' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 3) . '-' . substr($digits, 6);
        }

        return $phone;
    }

    public function getValidationRules(): array
    {
        return [
            'phone' => 'required|string',
            'country' => 'required|string|max:2',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.phone-validator';
    }
}
