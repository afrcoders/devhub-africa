<?php

namespace App\Http\Controllers\Africoders\Kortextools;

use App\Http\Controllers\Controller;
use App\Services\Kortextools\ToolService;
use App\Services\Kortextools\Handlers\ToolHandlerFactory;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    protected $toolService;
    protected $handlerFactory;

    public function __construct(ToolService $toolService, ToolHandlerFactory $handlerFactory)
    {
        $this->toolService = $toolService;
        $this->handlerFactory = $handlerFactory;
    }

    /**
     * Show all tools with filtering and pagination (or homepage)
     */
    public function index(Request $request)
    {
        // Get all tools from database
        $allTools = $this->toolService->getAllToolsFlat();

        // Get categories from database with icons
        $categoriesData = collect($allTools)->groupBy('category');

        $categories = $categoriesData->map(function ($tools, $name) {
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
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'icon' => $icons[$name] ?? 'fas fa-wrench',
                'count' => count($tools)
            ];
        })
        ->sortBy('name')
        ->values();

        // Always get featured tools for the index page
        $featuredTools = $this->toolService->getFeaturedTools(12);

        // Check if this is the homepage or the explore page
        if ($request->route()->getName() === 'tools.kortex.home' || $request->path() === '/') {
            // Return homepage view with featured tools and categories
            return view('africoders.kortextools.index', compact('featuredTools', 'categories'));
        }

        // Return tools listing page
        return view('africoders.kortextools.tools', compact('allTools', 'categories', 'featuredTools'));
    }

    /**
     * Show how it works page
     */
    public function howItWorks()
    {
        $pageData = [
            'metaTitle' => 'How KortexTools Works - Fast, Simple Online Tools',
            'metaDescription' => 'Learn how to use KortexTools to boost your productivity with our simple, no-registration-required online tools.',
        ];

        return view('africoders.kortextools.how-it-works', $pageData);
    }

    /**
     * Show single tool page
     */
    public function show(Request $request)
    {
        $slug = $request->slug;
        $tool = $this->toolService->getToolBySlug($slug);

        if (!$tool) {
            abort(404, 'Tool not found');
        }

        // Get related tools from same category
        $relatedTools = $this->toolService->getRelatedTools($tool->category, $tool->name, 3);

        return view('africoders.kortextools.tool-detail', compact('tool', 'relatedTools'));
    }

    /**
     * Show tools by category
     */
    public function showCategory(Request $request)
    {
        $category = $request->category;
        $data = $this->toolService->getCategoryInfo($category);

        if (!$data) {
            abort(404, 'Category not found');
        }

        return view('africoders.kortextools.category', $data);
    }

    /**
     * Show all tools organized by category
     */
    public function allTools()
    {
        // Get all tools grouped by category
        $toolsByCategory = $this->toolService->getAllToolsByCategory();

        // Sort categories alphabetically
        $sortedCategories = $toolsByCategory->sortKeys();

        // Sort tools within each category alphabetically
        $sortedCategories = $sortedCategories->map(function ($tools) {
            return $tools->sortBy('name');
        });

        $pageData = [
            'metaTitle' => 'All Tools A-Z - Complete KortexTools Directory',
            'metaDescription' => 'Browse our complete collection of ' . $this->toolService->getTotalToolsCount() . ' online tools organized by category from A to Z.',
            'toolsByCategory' => $sortedCategories,
            'totalTools' => $this->toolService->getTotalToolsCount()
        ];

        return view('africoders.kortextools.all-tools', $pageData);
    }

    /**
     * Handle tool submission (POST requests)
     */
    public function handle(Request $request, ToolService $toolService)
    {
        $slug = $request->slug;
        $tool = $this->toolService->getToolBySlug($slug);

        if (!$tool) {
            abort(404, 'Tool not found');
        }

        // Delegate to service to handle tool-specific logic
        return $toolService->handleTool($slug, $tool, $request);
    }
}
