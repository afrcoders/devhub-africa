<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class FakeNameGeneratorHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $count = min(intval($data['count'] ?? 5), 50);
        $gender = $data['gender'] ?? 'random';

        $names = [];
        $maleNames = ['John', 'James', 'Robert', 'Michael', 'William', 'David', 'Richard', 'Joseph', 'Thomas', 'Charles'];
        $femaleNames = ['Mary', 'Patricia', 'Jennifer', 'Linda', 'Barbara', 'Elizabeth', 'Susan', 'Jessica', 'Sarah', 'Karen'];
        $surnames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

        for ($i = 0; $i < $count; $i++) {
            if ($gender === 'male') {
                $first = $maleNames[array_rand($maleNames)];
            } elseif ($gender === 'female') {
                $first = $femaleNames[array_rand($femaleNames)];
            } else {
                $first = (rand(0, 1) ? $maleNames : $femaleNames)[array_rand(rand(0, 1) ? $maleNames : $femaleNames)];
            }
            $last = $surnames[array_rand($surnames)];
            $names[] = "$first $last";
        }

        return ['success' => true, 'names' => $names, 'count' => count($names)];
    }

    public function getValidationRules(): array
    {
        return [
            'count' => 'required|integer|min:1|max:50',
            'gender' => 'required|string|in:male,female,random'
        ];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.fake-name-generator';
    }
}
