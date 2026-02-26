<?php

namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class FakeAddressGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $country = $data['country'] ?? 'US';
        $count = intval($data['count'] ?? 1);
        $count = min(max($count, 1), 20); // Limit between 1-20

        try {
            $addresses = $this->generateAddresses($country, $count);

            return [
                'success' => true,
                'country' => $country,
                'count' => $count,
                'addresses' => $addresses
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to generate addresses: ' . $e->getMessage()
            ];
        }
    }

    public function getValidationRules(): array
    {
        return [
            'country' => 'required|in:US,UK,CA,AU,DE,FR,ES,IT,NL,BR,IN,JP,CN',
            'count' => 'sometimes|integer|min:1|max:20'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.fake-address-generator';
    }

    private function generateAddresses($country, $count)
    {
        $addresses = [];

        for ($i = 0; $i < $count; $i++) {
            switch ($country) {
                case 'US':
                    $addresses[] = $this->generateUSAddress();
                    break;
                case 'UK':
                    $addresses[] = $this->generateUKAddress();
                    break;
                case 'CA':
                    $addresses[] = $this->generateCAAddress();
                    break;
                case 'AU':
                    $addresses[] = $this->generateAUAddress();
                    break;
                case 'DE':
                    $addresses[] = $this->generateDEAddress();
                    break;
                default:
                    $addresses[] = $this->generateUSAddress(); // Fallback
                    break;
            }
        }

        return $addresses;
    }

    private function generateUSAddress()
    {
        $streets = ['Main St', 'Oak Ave', 'Pine Rd', 'Elm Dr', 'Maple Ln', 'Cedar Blvd', 'Park Ave', 'First St'];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego'];
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ', 'PA', 'FL', 'OH'];

        return [
            'street' => rand(100, 9999) . ' ' . $streets[array_rand($streets)],
            'city' => $cities[array_rand($cities)],
            'state' => $states[array_rand($states)],
            'zip_code' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
            'country' => 'United States'
        ];
    }

    private function generateUKAddress()
    {
        $streets = ['High Street', 'Church Lane', 'Victoria Road', 'King Street', 'Queen Street', 'Mill Lane'];
        $cities = ['London', 'Birmingham', 'Manchester', 'Liverpool', 'Leeds', 'Sheffield', 'Bristol', 'Edinburgh'];

        return [
            'street' => rand(1, 200) . ' ' . $streets[array_rand($streets)],
            'city' => $cities[array_rand($cities)],
            'state' => 'England',
            'zip_code' => $this->generateUKPostcode(),
            'country' => 'United Kingdom'
        ];
    }

    private function generateCAAddress()
    {
        $streets = ['Main St', 'King St', 'Queen St', 'Yonge St', 'Bloor St', 'College St'];
        $cities = ['Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Ottawa', 'Edmonton', 'Winnipeg', 'Quebec City'];
        $provinces = ['ON', 'QC', 'BC', 'AB', 'MB', 'SK', 'NS', 'NB'];

        return [
            'street' => rand(100, 9999) . ' ' . $streets[array_rand($streets)],
            'city' => $cities[array_rand($cities)],
            'state' => $provinces[array_rand($provinces)],
            'zip_code' => $this->generateCanadianPostcode(),
            'country' => 'Canada'
        ];
    }

    private function generateAUAddress()
    {
        $streets = ['Collins St', 'Bourke St', 'George St', 'Pitt St', 'King St', 'Queen St'];
        $cities = ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide', 'Gold Coast', 'Newcastle', 'Canberra'];
        $states = ['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'];

        return [
            'street' => rand(1, 500) . ' ' . $streets[array_rand($streets)],
            'city' => $cities[array_rand($cities)],
            'state' => $states[array_rand($states)],
            'zip_code' => str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
            'country' => 'Australia'
        ];
    }

    private function generateDEAddress()
    {
        $streets = ['Hauptstraße', 'Bahnhofstraße', 'Kirchstraße', 'Schulstraße', 'Gartenstraße', 'Berliner Str'];
        $cities = ['Berlin', 'Hamburg', 'Munich', 'Cologne', 'Frankfurt', 'Stuttgart', 'Düsseldorf', 'Dortmund'];

        return [
            'street' => $streets[array_rand($streets)] . ' ' . rand(1, 200),
            'city' => $cities[array_rand($cities)],
            'state' => 'Deutschland',
            'zip_code' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
            'country' => 'Germany'
        ];
    }

    private function generateUKPostcode()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $area = $letters[rand(0, 25)] . $letters[rand(0, 25)];
        $district = rand(1, 99);
        $sector = rand(1, 9);
        $unit = $letters[rand(0, 25)] . $letters[rand(0, 25)];

        return $area . $district . ' ' . $sector . $unit;
    }

    private function generateCanadianPostcode()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';

        return $letters[rand(0, 25)] . $digits[rand(0, 9)] . $letters[rand(0, 25)] . ' ' .
               $digits[rand(0, 9)] . $letters[rand(0, 25)] . $digits[rand(0, 9)];
    }
}
