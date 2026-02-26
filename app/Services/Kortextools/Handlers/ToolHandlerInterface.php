<?php

namespace App\Services\Kortextools\Handlers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface ToolHandlerInterface
{
    /**
     * Handle tool processing
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request);

    /**
     * Validate tool input
     *
     * @param Request $request
     * @return array Validation rules
     */
    public function getValidationRules();

    /**
     * Get tool template/view name
     *
     * @return string
     */
    public function getTemplate();
}
