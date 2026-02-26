<?php

namespace App\Services\Kortextools;

use App\Models\KortexTool;

class ToolService
{
    /**
     * Get all tools grouped by category
     *
     * @return array
     */
    public function getAllToolsByCategory()
    {
        return KortexTool::getByCategory();
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCategories()
    {
        return KortexTool::getCategories();
    }

    /**
     * Get a specific tool by slug
     *
     * @param string $slug
     * @return KortexTool|null
     */
    public function getToolBySlug($slug)
    {
        return KortexTool::active()->where('slug', $slug)->first();
    }

    /**
     * Get tools by category
     *
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getToolsByCategory($category)
    {
        return KortexTool::active()
                        ->category($category)
                        ->orderByDesc('popularity')
                        ->orderByDesc('rating')
                        ->get();
    }

    /**
     * Search tools
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchTools($query)
    {
        return KortexTool::active()
                        ->where(function ($q) use ($query) {
                            $q->where('name', 'like', "%{$query}%")
                              ->orWhere('description', 'like', "%{$query}%")
                              ->orWhere('slug', 'like', "%{$query}%");
                        })
                        ->orderByDesc('popularity')
                        ->orderByDesc('rating')
                        ->get();
    }

    /**
     * Get featured/popular tools
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedTools($limit = 12)
    {
        return KortexTool::active()
                        ->orderByDesc('popularity')
                        ->orderByDesc('rating')
                        ->limit($limit)
                        ->get();
    }

    /**
     * Get total tools count
     *
     * @return int
     */
    public function getTotalToolsCount()
    {
        return KortexTool::active()->count();
    }

    /**
     * Get total categories count
     *
     * @return int
     */
    public function getTotalCategoriesCount()
    {
        return KortexTool::active()->distinct('category')->count();
    }

    /**
     * Legacy method compatibility - get all tools configuration
     * Returns tools in the old config format for backward compatibility
     */
    public function getAllTools()
    {
        $tools = KortexTool::getByCategory();
        $result = [];

        foreach ($tools as $category => $categoryTools) {
            $result[$category] = $categoryTools->map(function ($tool) {
                return [
                    'icon' => $tool->icon,
                    'name' => $tool->name,
                    'slug' => $tool->slug,
                    'description' => $tool->description,
                    'metaTitle' => $tool->meta_title,
                    'metaDescription' => $tool->meta_description,
                    'popularity' => $tool->popularity,
                    'rating' => $tool->rating,
                    'rating_count' => $tool->rating_count,
                ];
            })->toArray();
        }

        return $result;
    }

    /**
     * Get flat list of all tools - legacy method
     */
    public function getAllToolsFlat()
    {
        return KortexTool::active()->get()->map(function ($tool) {
            return [
                'icon' => $tool->icon,
                'name' => $tool->name,
                'slug' => $tool->slug,
                'description' => $tool->description,
                'category' => $tool->category,
                'metaTitle' => $tool->meta_title,
                'metaDescription' => $tool->meta_description,
                'popularity' => $tool->popularity,
                'rating' => $tool->rating,
                'rating_count' => $tool->rating_count,
            ];
        })->toArray();
    }

    /**
     * Legacy method - find tool by slug (returns array format)
     *
     * @param string $slug
     * @return array|null
     */
    public function findToolBySlug($slug)
    {
        $tool = $this->getToolBySlug($slug);

        if (!$tool) {
            return null;
        }

        return [
            'icon' => $tool->icon,
            'name' => $tool->name,
            'slug' => $tool->slug,
            'description' => $tool->description,
            'category' => $tool->category,
            'metaTitle' => $tool->meta_title,
            'metaDescription' => $tool->meta_description,
            'popularity' => $tool->popularity,
            'rating' => $tool->rating,
            'rating_count' => $tool->rating_count,
        ];
    }

    /**
     * Get related tools from the same category, excluding the current tool
     */
    public function getRelatedTools($category, $currentToolName, $limit = 3)
    {
        return KortexTool::active()
            ->where('category', $category)
            ->where('name', '!=', $currentToolName)
            ->limit($limit)
            ->get()
            ->map(function ($tool) {
                return [
                    'icon' => $tool->icon,
                    'name' => $tool->name,
                    'slug' => $tool->slug,
                    'description' => $tool->description,
                    'category' => $tool->category,
                ];
            })
            ->toArray();
    }

    /**
     * Get category information and tools
     */
    public function getCategoryInfo($categorySlug)
    {
        // Convert slug back to proper category name
        $categoryName = $this->slugToCategoryName($categorySlug);

        if (!$categoryName) {
            return null;
        }

        $tools = $this->getToolsByCategory($categoryName);

        if (empty($tools) || $tools->isEmpty()) {
            return null;
        }

        return [
            'category' => $categoryName,
            'tools' => $tools,
            'total' => $tools->count()
        ];
    }

    /**
     * Convert category slug to proper category name
     */
    private function slugToCategoryName($slug)
    {
        // Get all available categories from database
        $categories = KortexTool::active()->distinct()->pluck('category');

        // Find matching category by comparing slugs
        foreach ($categories as $category) {
            if (\Illuminate\Support\Str::slug($category) === $slug) {
                return $category;
            }
        }

        return null;
    }

    /**
     * Handle tool processing
     */
    public function handleTool($slug, $tool, $request)
    {
        try {
            $handler = \App\Services\Kortextools\Handlers\ToolHandlerFactory::getHandler($slug);

            if (!$handler) {
                // Fall back to GenericToolHandler
                $handler = new \App\Services\Kortextools\Handlers\GenericToolHandler($tool);
            }

            // Call the handler's handle method
            $result = $handler->handle($request);

            // If result is already a response, return it
            if ($result instanceof \Illuminate\Http\Response || $result instanceof \Illuminate\View\View) {
                return $result;
            }

            return response()->json([
                'status' => 'success',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            \Log::error("Tool handling error for {$slug}: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error processing tool: ' . $e->getMessage()
            ], 500);
        }
    }
}
