<?php

namespace App\Services\Kortextools\Handlers;

class SmallTextGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $text = $data['text'] ?? '';
        $styleType = $data['style_type'] ?? 'superscript';

        $result = match ($styleType) {
            'superscript' => $this->toSuperscript($text),
            'subscript' => $this->toSubscript($text),
            'strikethrough' => $this->toStrikethrough($text),
            'bold' => $this->toBold($text),
            'italic' => $this->toItalic($text),
            'tiny' => $this->toTiny($text),
            default => $text,
        };

        return [
            'success' => true,
            'result' => $result,
            'original' => $text,
            'style_type' => $styleType,
            'description' => $this->getDescription($styleType),
        ];
    }

    private function toSuperscript(string $text): string
    {
        $map = [
            '0' => '⁰', '1' => '¹', '2' => '²', '3' => '³', '4' => '⁴',
            '5' => '⁵', '6' => '⁶', '7' => '⁷', '8' => '⁸', '9' => '⁹',
            'a' => 'ᵃ', 'b' => 'ᵇ', 'c' => 'ᶜ', 'd' => 'ᵈ', 'e' => 'ᵉ',
            'f' => 'ᶠ', 'g' => 'ᵍ', 'h' => 'ʰ', 'i' => 'ᵢ', 'j' => 'ʲ',
        ];
        return strtr(strtolower($text), $map);
    }

    private function toSubscript(string $text): string
    {
        $map = [
            '0' => '₀', '1' => '₁', '2' => '₂', '3' => '₃', '4' => '₄',
            '5' => '₅', '6' => '₆', '7' => '₇', '8' => '₈', '9' => '₉',
            'a' => 'ₐ', 'e' => 'ₑ', 'i' => 'ᵢ', 'o' => 'ₒ', 'u' => 'ᵤ',
        ];
        return strtr(strtolower($text), $map);
    }

    private function toStrikethrough(string $text): string
    {
        return '̶' . implode('̶', str_split($text)) . '̶';
    }

    private function toBold(string $text): string
    {
        $map = [
            'A' => '𝐀', 'B' => '𝐁', 'C' => '𝐂', 'D' => '𝐃', 'E' => '𝐄',
            'a' => '𝐚', 'b' => '𝐛', 'c' => '𝐜', 'd' => '𝐝', 'e' => '𝐞',
        ];
        return strtr($text, $map);
    }

    private function toItalic(string $text): string
    {
        $map = [
            'A' => '𝐴', 'B' => '𝐵', 'C' => '𝐶', 'D' => '𝐷', 'E' => '𝐸',
            'a' => '𝑎', 'b' => '𝑏', 'c' => '𝑐', 'd' => '𝑑', 'e' => '𝑒',
        ];
        return strtr($text, $map);
    }

    private function toTiny(string $text): string
    {
        $map = [
            'A' => 'ᴀ', 'B' => 'ʙ', 'C' => 'ᴄ', 'D' => 'ᴅ', 'E' => 'ᴇ',
            'a' => 'ᴀ', 'b' => 'ʙ', 'c' => 'ᴄ', 'd' => 'ᴅ', 'e' => 'ᴇ',
        ];
        return strtr($text, $map);
    }

    private function getDescription(string $style): string
    {
        return match ($style) {
            'superscript' => 'Convert to superscript (raised) text',
            'subscript' => 'Convert to subscript (lowered) text',
            'strikethrough' => 'Add strikethrough to text',
            'bold' => 'Convert to bold Unicode characters',
            'italic' => 'Convert to italic Unicode characters',
            'tiny' => 'Convert to tiny uppercase characters',
            default => '',
        };
    }

    public function getValidationRules(): array
    {
        return [
            'text' => 'required|string',
            'style_type' => 'required|string|in:superscript,subscript,strikethrough,bold,italic,tiny',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.small-text-generator';
    }
}
