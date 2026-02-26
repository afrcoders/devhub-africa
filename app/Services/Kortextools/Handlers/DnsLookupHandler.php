<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class DnsLookupHandler implements ToolHandlerInterface
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
            $dnsRecords = $this->getDnsRecords($domain);

            return [
                'success' => true,
                'domain' => $domain,
                'dns_records' => $dnsRecords
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'DNS lookup failed: ' . $e->getMessage()
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
        return 'africoders.kortextools.tools.dns-lookup';
    }

    private function getDnsRecords($domain)
    {
        $records = [];

        // A Records
        $aRecords = dns_get_record($domain, DNS_A);
        if ($aRecords) {
            $records['A'] = array_map(function($record) {
                return $record['ip'];
            }, $aRecords);
        }

        // AAAA Records (IPv6)
        $aaaaRecords = dns_get_record($domain, DNS_AAAA);
        if ($aaaaRecords) {
            $records['AAAA'] = array_map(function($record) {
                return $record['ipv6'];
            }, $aaaaRecords);
        }

        // CNAME Records
        $cnameRecords = dns_get_record($domain, DNS_CNAME);
        if ($cnameRecords) {
            $records['CNAME'] = array_map(function($record) {
                return $record['target'];
            }, $cnameRecords);
        }

        // MX Records
        $mxRecords = dns_get_record($domain, DNS_MX);
        if ($mxRecords) {
            $records['MX'] = array_map(function($record) {
                return $record['target'] . ' (Priority: ' . $record['pri'] . ')';
            }, $mxRecords);
        }

        // NS Records
        $nsRecords = dns_get_record($domain, DNS_NS);
        if ($nsRecords) {
            $records['NS'] = array_map(function($record) {
                return $record['target'];
            }, $nsRecords);
        }

        // TXT Records
        $txtRecords = dns_get_record($domain, DNS_TXT);
        if ($txtRecords) {
            $records['TXT'] = array_map(function($record) {
                return $record['txt'];
            }, $txtRecords);
        }

        // SOA Records
        $soaRecords = dns_get_record($domain, DNS_SOA);
        if ($soaRecords) {
            $records['SOA'] = array_map(function($record) {
                return $record['mname'] . ' (Serial: ' . $record['serial'] . ')';
            }, $soaRecords);
        }

        return $records;
    }
}
