<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class IbanValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $iban = preg_replace('/\s/', '', strtoupper($data['iban'] ?? ''));

        $isValid = $this->validateIBAN($iban);
        $info = $isValid ? $this->extractIBANInfo($iban) : null;

        return [
            'success' => true,
            'is_valid' => $isValid,
            'iban' => $iban,
            'info' => $info,
            'message' => $isValid ? 'Valid IBAN' : 'Invalid IBAN'
        ];
    }

    private function validateIBAN($iban): bool
    {
        if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $iban)) {
            return false;
        }

        $rearranged = substr($iban, 4) . substr($iban, 0, 4);
        $numeric = '';

        foreach (str_split($rearranged) as $char) {
            if (is_numeric($char)) {
                $numeric .= $char;
            } else {
                $numeric .= (ord($char) - ord('A') + 10);
            }
        }

        return bcmod($numeric, '97') === '1';
    }

    private function extractIBANInfo($iban): array
    {
        $countryCode = substr($iban, 0, 2);
        $checkDigits = substr($iban, 2, 2);
        $bban = substr($iban, 4);

        $countries = [
            'DE' => 'Germany',
            'FR' => 'France',
            'GB' => 'United Kingdom',
            'ES' => 'Spain',
            'IT' => 'Italy',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'AT' => 'Austria',
            'CH' => 'Switzerland',
            'IE' => 'Ireland',
        ];

        return [
            'country_code' => $countryCode,
            'country' => $countries[$countryCode] ?? 'Unknown',
            'check_digits' => $checkDigits,
            'bban' => $bban,
            'length' => strlen($iban)
        ];
    }

    public function getValidationRules(): array
    {
        return [
            'iban' => 'required|string|min:15|max:34',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.iban-validator';
    }
}
