<?php

namespace App\Services\Kortextools\Handlers;

class FakeCreditCardGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $cardType = $data['card_type'] ?? 'visa';
        $count = intval($data['count'] ?? 1);

        if ($count < 1 || $count > 20) {
            $count = 1;
        }

        $cards = [];
        for ($i = 0; $i < $count; $i++) {
            $cards[] = $this->generateCard($cardType);
        }

        return [
            'success' => true,
            'cards' => $cards,
            'card_type' => $cardType,
            'count' => count($cards),
            'disclaimer' => 'These are test/dummy cards for development only. Not for real transactions.',
        ];
    }

    private function generateCard(string $type): array
    {
        $card = [
            'type' => $type,
            'number' => $this->generateCardNumber($type),
            'expiry' => $this->generateExpiry(),
            'cvv' => strval(random_int(100, 999)),
            'cardholder' => $this->generateName(),
        ];
        return $card;
    }

    private function generateCardNumber(string $type): string
    {
        $prefix = match ($type) {
            'visa' => '4',
            'mastercard' => '5',
            'amex' => '3',
            'discover' => '6',
            default => '4',
        };

        $length = $type === 'amex' ? 15 : 16;
        $number = $prefix;

        for ($i = 1; $i < $length; $i++) {
            $number .= random_int(0, 9);
        }

        return implode(' ', str_split($number, 4));
    }

    private function generateExpiry(): string
    {
        $month = str_pad(random_int(1, 12), 2, '0', STR_PAD_LEFT);
        $year = strval(date('y') + random_int(1, 8));
        return $month . '/' . $year;
    }

    private function generateName(): string
    {
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emma', 'Robert', 'Lisa'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis'];

        $first = $firstNames[array_rand($firstNames)];
        $last = $lastNames[array_rand($lastNames)];

        return $first . ' ' . $last;
    }

    public function getValidationRules(): array
    {
        return [
            'card_type' => 'string|in:visa,mastercard,amex,discover',
            'count' => 'integer|min:1|max:20',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.fake-credit-card-generator';
    }
}
