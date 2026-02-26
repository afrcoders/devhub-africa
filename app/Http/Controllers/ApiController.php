<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * API Base Controller
 * All API controllers should extend this to get standard response methods.
 */
class ApiController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    use ApiResponse;

    /**
     * Get the authenticated service from the request.
     *
     * @return string|null
     */
    protected function getService(): ?string
    {
        return request()->attributes->get('service_id');
    }

    /**
     * Get the API token from the request.
     *
     * @return string|null
     */
    protected function getToken(): ?string
    {
        return request()->attributes->get('api_token');
    }

    /**
     * Get the request ID.
     *
     * @return string|null
     */
    protected function getRequestId(): ?string
    {
        return request()->attributes->get('request_id');
    }
}
