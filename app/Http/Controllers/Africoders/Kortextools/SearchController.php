<?php

namespace App\Http\Controllers\Africoders\Kortextools;

use App\Http\Controllers\Controller;
use App\Services\Kortextools\ToolService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    protected $toolService;

    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    /**
     * Search tools by query
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $results = [];

        if (!empty($query)) {
            $results = $this->toolService->searchTools($query);
        }

        return view('africoders.kortextools.search', [
            'query' => $query,
            'results' => $results,
            'resultsCount' => count($results)
        ]);
    }
}
