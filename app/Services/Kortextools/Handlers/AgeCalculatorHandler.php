<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgeCalculatorHandler implements ToolHandlerInterface
{
    /**
     * Handle age calculation
     */
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $birthDate = $request->input('birth_date');

            $birth = new \DateTime($birthDate);
            $today = new \DateTime('today');
            $age = $birth->diff($today);

            return response()->json([
                'success' => true,
                'data' => [
                    'birth_date' => $birthDate,
                    'age_years' => $age->y,
                    'age_months' => $age->m,
                    'age_days' => $age->d,
                    'total_days' => $age->days,
                    'formatted' => $age->y . ' years, ' . $age->m . ' months, ' . $age->d . ' days',
                    'next_birthday' => $this->getNextBirthday($birth),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get next birthday
     */
    private function getNextBirthday(\DateTime $birthDate)
    {
        $today = new \DateTime('today');
        $nextBirthday = new \DateTime($birthDate->format('Y-m-d'));
        $nextBirthday->setDate($today->format('Y'), $birthDate->format('m'), $birthDate->format('d'));

        if ($nextBirthday < $today) {
            $nextBirthday->modify('+1 year');
        }

        $daysUntil = $today->diff($nextBirthday)->days;

        return [
            'date' => $nextBirthday->format('Y-m-d'),
            'days_until' => $daysUntil,
        ];
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'birth_date' => 'required|date|before:today',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'age-calculator';
    }
}
