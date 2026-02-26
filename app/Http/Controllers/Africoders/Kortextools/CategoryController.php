<?php

namespace App\Http\Controllers\Africoders\Kortextools;

use App\Http\Controllers\Controller;
use App\Services\Kortextools\ToolService;
use App\Models\KortexTool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $toolService;

    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    /**
     * Show all categories with sample tools
     */
    public function index()
    {
        // Get all categories from the database with their tools
        $categoriesData = KortexTool::where('is_active', true)
            ->select('category', 'name', 'slug', 'description')
            ->get()
            ->groupBy('category');

        $categories = $categoriesData->map(function ($tools, $categoryName) {
            // Define icons for different categories
            $icons = [
                'Text Tools' => 'fas fa-font',
                'Calculators' => 'fas fa-calculator',
                'Converters' => 'fas fa-exchange-alt',
                'Developer Tools' => 'fas fa-code',
                'Financial' => 'fas fa-dollar-sign',
                'Generators' => 'fas fa-magic',
                'Image Tools' => 'fas fa-image',
                'Media Tools' => 'fas fa-play-circle',
                'Network Tools' => 'fas fa-network-wired',
                'PDF Tools' => 'fas fa-file-pdf',
                'Programming' => 'fas fa-laptop-code',
                'Security Tools' => 'fas fa-shield-alt',
                'SEO Tools' => 'fas fa-search',
                'Utilities' => 'fas fa-wrench',
            ];

            return [
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'icon' => $icons[$categoryName] ?? 'fas fa-wrench',
                'tools' => $tools->take(6)->toArray(), // Show 6 tools per category
                'count' => $tools->count(),
                'description' => "Powerful {$categoryName} to enhance your productivity",
            ];
        })
        ->sortBy('name')
        ->values();

        return view('africoders.kortextools.categories', compact('categories'));
    }
}
