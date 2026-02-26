<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimestampConverterHandler implements ToolHandlerInterface
{
    /**
     * Handle timestamp conversion
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
            $operation = $request->input('operation', 'to_timestamp');
            $timezone = $request->input('timezone', 'UTC');

            $result = null;

            if ($operation === 'to_timestamp') {
                $dateString = $request->input('datetime');
                $timestamp = strtotime($dateString);

                if ($timestamp === false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid date format'
                    ], 422);
                }

                $result = [
                    'unix_timestamp' => $timestamp,
                    'milliseconds' => $timestamp * 1000,
                    'input' => $dateString,
                ];
            } else {
                $timestamp = (int)$request->input('timestamp');
                $date = new \DateTime('@' . $timestamp);
                $date->setTimezone(new \DateTimeZone($timezone));

                $result = [
                    'iso_8601' => $date->format('Y-m-d\TH:i:sP'),
                    'readable' => $date->format('l, F j, Y g:i A'),
                    'mysql' => $date->format('Y-m-d H:i:s'),
                    'unix_timestamp' => $timestamp,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules
     */
    public function getValidationRules()
    {
        return [
            'operation' => 'required|in:to_timestamp,from_timestamp',
            'datetime' => 'required_if:operation,to_timestamp|string',
            'timestamp' => 'required_if:operation,from_timestamp|integer',
            'timezone' => 'string|timezone',
        ];
    }

    /**
     * Get template name
     */
    public function getTemplate()
    {
        return 'timestamp-converter';
    }
}
