<?php

namespace App\Contracts;

interface ToolHandlerInterface
{
    /**
     * Handle the tool processing request
     *
     * @param array $data
     * @return array
     */
    public function handle(array $data): array;

    /**
     * Get validation rules for the tool
     *
     * @return array
     */
    public function getValidationRules(): array;

    /**
     * Get the template name for the tool
     *
     * @return string
     */
    public function getTemplate(): string;
}
