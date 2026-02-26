<?php

namespace App\Services\Kortextools\Handlers;

class XmlValidatorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $xml = $data['xml'] ?? '';

        if (empty(trim($xml))) {
            return [
                'success' => false,
                'is_valid' => false,
                'error' => 'XML content is empty',
            ];
        }

        libxml_use_internal_errors(true);
        $doc = simplexml_load_string($xml);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if ($doc === false || !empty($errors)) {
            $errorMsg = '';
            if (!empty($errors)) {
                $errorMsg = $errors[0]->message . ' (Line: ' . $errors[0]->line . ')';
            } else {
                $errorMsg = 'Invalid XML format';
            }

            return [
                'success' => false,
                'is_valid' => false,
                'error' => $errorMsg,
            ];
        }

        return [
            'success' => true,
            'is_valid' => true,
            'message' => 'Valid XML',
            'root_element' => $doc->getName(),
            'formatted' => $this->formatXml($xml),
        ];
    }

    private function formatXml(string $xml): string
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->load(stream_context_create(), LIBXML_NOERROR);
        @$dom->loadXML($xml);
        $dom->formatOutput = true;
        return $dom->saveXML() ?: $xml;
    }

    public function getValidationRules(): array
    {
        return [
            'xml' => 'required|string',
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.xml-validator';
    }
}
