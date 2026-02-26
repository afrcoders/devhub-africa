<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class DomainAgeCheckerHandler implements ToolHandlerInterface
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
            $domainInfo = $this->getDomainAge($domain);

            return [
                'success' => true,
                'domain' => $domain,
                'domain_info' => $domainInfo
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Could not retrieve domain information: ' . $e->getMessage()
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
        return 'africoders.kortextools.tools.domain-age-checker';
    }

    private function getDomainAge($domain)
    {
        // Use a simple whois lookup approach
        $whoisServers = [
            'com' => 'whois.verisign-grs.com',
            'net' => 'whois.verisign-grs.com',
            'org' => 'whois.pir.org',
            'info' => 'whois.afilias.net',
            'biz' => 'whois.neulevel.biz',
            'us' => 'whois.nic.us'
        ];

        $tld = strtolower(pathinfo($domain, PATHINFO_EXTENSION));
        $whoisServer = $whoisServers[$tld] ?? $whoisServers['com'];

        try {
            $whoisData = $this->queryWhois($domain, $whoisServer);
            return $this->parseWhoisData($whoisData, $domain);
        } catch (\Exception $e) {
            // Fallback to DNS-based approach
            return $this->getDnsBasedInfo($domain);
        }
    }

    private function queryWhois($domain, $server)
    {
        $fp = @fsockopen($server, 43, $errno, $errstr, 10);

        if (!$fp) {
            throw new \Exception("Cannot connect to whois server");
        }

        fputs($fp, $domain . "\r\n");
        $output = '';

        while (!feof($fp)) {
            $output .= fgets($fp, 128);
        }

        fclose($fp);
        return $output;
    }

    private function parseWhoisData($whoisData, $domain)
    {
        $creationDate = null;
        $expirationDate = null;
        $registrar = null;
        $nameServers = [];

        // Parse creation date
        if (preg_match('/Creation Date:\s*(.+)/i', $whoisData, $matches) ||
            preg_match('/Created On:\s*(.+)/i', $whoisData, $matches) ||
            preg_match('/Domain Name Commencement Date:\s*(.+)/i', $whoisData, $matches)) {
            $creationDate = trim($matches[1]);
        }

        // Parse expiration date
        if (preg_match('/Expir(?:y|ation) Date:\s*(.+)/i', $whoisData, $matches) ||
            preg_match('/Expires On:\s*(.+)/i', $whoisData, $matches)) {
            $expirationDate = trim($matches[1]);
        }

        // Parse registrar
        if (preg_match('/Registrar:\s*(.+)/i', $whoisData, $matches)) {
            $registrar = trim($matches[1]);
        }

        // Parse name servers
        if (preg_match_all('/Name Server:\s*(.+)/i', $whoisData, $matches)) {
            $nameServers = array_map('trim', $matches[1]);
        }

        $age = null;
        $ageFormatted = 'Unknown';

        if ($creationDate) {
            try {
                $createdTime = strtotime($creationDate);
                if ($createdTime) {
                    $age = time() - $createdTime;
                    $years = floor($age / (365.25 * 24 * 3600));
                    $months = floor(($age % (365.25 * 24 * 3600)) / (30.44 * 24 * 3600));
                    $days = floor(($age % (30.44 * 24 * 3600)) / (24 * 3600));

                    $ageFormatted = '';
                    if ($years > 0) $ageFormatted .= $years . ' year' . ($years > 1 ? 's' : '');
                    if ($months > 0) $ageFormatted .= ($ageFormatted ? ', ' : '') . $months . ' month' . ($months > 1 ? 's' : '');
                    if ($days > 0 && $years == 0) $ageFormatted .= ($ageFormatted ? ', ' : '') . $days . ' day' . ($days > 1 ? 's' : '');

                    if (!$ageFormatted) $ageFormatted = 'Less than a day';
                }
            } catch (\Exception $e) {
                // Invalid date format, keep as unknown
            }
        }

        return [
            'creation_date' => $creationDate ?: 'Unknown',
            'expiration_date' => $expirationDate ?: 'Unknown',
            'age_days' => $age ? floor($age / 86400) : null,
            'age_formatted' => $ageFormatted,
            'registrar' => $registrar ?: 'Unknown',
            'name_servers' => $nameServers
        ];
    }

    private function getDnsBasedInfo($domain)
    {
        // Fallback method using DNS queries
        $ip = gethostbyname($domain);

        if ($ip === $domain) {
            throw new \Exception("Domain does not exist or cannot be resolved");
        }

        return [
            'creation_date' => 'Unknown (WHOIS unavailable)',
            'expiration_date' => 'Unknown (WHOIS unavailable)',
            'age_days' => null,
            'age_formatted' => 'Unknown (WHOIS unavailable)',
            'registrar' => 'Unknown (WHOIS unavailable)',
            'name_servers' => [],
            'ip_address' => $ip
        ];
    }
}
