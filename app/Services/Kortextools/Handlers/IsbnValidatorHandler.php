<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class IsbnValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $isbn = preg_replace('/[^0-9X]/', '', strtoupper($data['isbn'] ?? ''));

        $isISBN10 = $this->validateISBN10($isbn);
        $isISBN13 = $this->validateISBN13($isbn);

        $type = null;
        if ($isISBN10) $type = 'ISBN-10';
        if ($isISBN13) $type = 'ISBN-13';

        return [
            'success' => true,
            'is_valid' => $isISBN10 || $isISBN13,
            'isbn' => $data['isbn'],
            'isbn_clean' => $isbn,
            'type' => $type,
            'message' => ($isISBN10 || $isISBN13) ? "Valid {$type}" : 'Invalid ISBN'
        ];
    }

    private function validateISBN10($isbn): bool
    {
        if (strlen($isbn) !== 10) return false;
        if (!preg_match('/^[0-9]{9}[0-9X]$/', $isbn)) return false;

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($isbn[$i]) * (10 - $i);
        }

        $check = $isbn[9] === 'X' ? 10 : intval($isbn[9]);
        return ($sum + $check) % 11 === 0;
    }

    private function validateISBN13($isbn): bool
    {
        if (strlen($isbn) !== 13) return false;
        if (!preg_match('/^[0-9]{13}$/', $isbn)) return false;

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $weight = ($i % 2 === 0) ? 1 : 3;
            $sum += intval($isbn[$i]) * $weight;
        }

        $check = (10 - ($sum % 10)) % 10;
        return intval($isbn[12]) === $check;
    }

    public function getValidationRules(): array
    {
        return [
            'isbn' => 'required|string|min:10|max:17',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.isbn-validator';
    }
}
