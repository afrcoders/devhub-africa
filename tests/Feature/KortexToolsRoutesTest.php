<?php

namespace Tests\Feature;

use Tests\TestCase;

class KortexToolsRoutesTest extends TestCase
{
    /**
     * Test that KortexTools routes are registered
     */
    public function test_kortextools_routes_exist(): void
    {
        $routes = \Route::getRoutes();
        $kortextoolsRoutes = [];

        foreach ($routes as $route) {
            if (strpos($route->getName() ?? '', 'tools.kortex') === 0 || strpos($route->getName() ?? '', 'admin.kortextools') === 0) {
                $kortextoolsRoutes[] = $route->getName();
            }
        }

        // Verify at least the main routes exist
        $expectedRoutes = [
            'tools.kortex.home',
            'tools.kortex.tools.index',
            'tools.kortex.categories.index',
            'tools.kortex.tool.show',
            'tools.kortex.search',
            'admin.kortextools.dashboard',
        ];

        foreach ($expectedRoutes as $routeName) {
            $this->assertContains($routeName, $kortextoolsRoutes, "Route $routeName not found");
        }
    }

    /**
     * Test that all KortexTools controllers exist
     */
    public function test_kortextools_controllers_exist(): void
    {
        $controllers = [
            \App\Http\Controllers\Africoders\Kortextools\ToolsController::class,
            \App\Http\Controllers\Africoders\Kortextools\CategoryController::class,
            \App\Http\Controllers\Africoders\Kortextools\SearchController::class,
            \App\Http\Controllers\Africoders\Kortextools\ToolRatingController::class,
        ];

        foreach ($controllers as $controller) {
            $this->assertTrue(class_exists($controller), "Controller $controller does not exist");
        }
    }

    /**
     * Test that KortexTools config is loaded
     */
    public function test_kortextools_config_loaded(): void
    {
        $config = config('kortextools.tools');

        $this->assertIsArray($config, 'KortexTools config not loaded');
        $this->assertGreaterThan(0, count($config), 'KortexTools config is empty');

        // Verify categories exist
        $categories = array_keys($config);
        $this->assertContains('PDF', $categories);
        $this->assertContains('Developer Tools', $categories);
    }

    /**
     * Test that all tool categories have tools
     */
    public function test_kortextools_all_categories_have_tools(): void
    {
        $config = config('kortextools.tools');

        foreach ($config as $category => $tools) {
            $this->assertIsArray($tools, "Category $category is not an array");
            $this->assertGreaterThan(0, count($tools), "Category $category has no tools");

            // Verify each tool has required fields
            foreach ($tools as $tool) {
                $this->assertArrayHasKey('name', $tool, "Tool in $category missing 'name'");
                $this->assertArrayHasKey('slug', $tool, "Tool in $category missing 'slug'");
                $this->assertArrayHasKey('description', $tool, "Tool in $category missing 'description'");
            }
        }
    }

    /**
     * Test that ToolService methods work
     */
    public function test_tool_service_methods(): void
    {
        $service = app(\App\Services\Kortextools\ToolService::class);

        // Test finding a tool by slug
        $tool = $service->findToolBySlug('json-formatter');
        $this->assertIsArray($tool, 'Tool should be found');
        $this->assertEquals('json-formatter', $tool['slug']);

        // Test finding invalid tool
        $invalidTool = $service->findToolBySlug('non-existent-tool-xyz123');
        $this->assertNull($invalidTool, 'Non-existent tool should return null');

        // Test getting related tools (should work regardless of category case)
        $relatedTools = $service->getRelatedTools('Developer Tools', 'JSON Formatter', 3);
        $this->assertIsArray($relatedTools, 'Related tools should be returned');
    }

    /**
     * Test that all views are loadable
     */
    public function test_kortextools_views_exist(): void
    {
        $views = [
            'africoders.kortextools.layout',
            'africoders.kortextools.index',
            'africoders.kortextools.tools',
            'africoders.kortextools.categories',
            'africoders.kortextools.category',
            'africoders.kortextools.how-it-works',
            'africoders.kortextools.search',
            'africoders.kortextools.tool-detail',
        ];

        $viewFactory = view();

        foreach ($views as $view) {
            $this->assertTrue($viewFactory->exists($view), "View $view does not exist");
        }
    }

    /**
     * Test that public routes can handle requests
     */
    public function test_public_routes_respond(): void
    {
        $routes = [
            ['path' => '/', 'method' => 'GET', 'name' => 'home'],
            ['path' => '/explore', 'method' => 'GET', 'name' => 'explore'],
            ['path' => '/categories', 'method' => 'GET', 'name' => 'categories'],
            ['path' => '/how-it-works', 'method' => 'GET', 'name' => 'how-it-works'],
            ['path' => '/search', 'method' => 'GET', 'name' => 'search'],
            ['path' => '/tool/json-formatter', 'method' => 'GET', 'name' => 'tool show'],
            ['path' => '/tools/pdf', 'method' => 'GET', 'name' => 'tools by category (PDF)'],
        ];

        // Test with the test kernel directly
        foreach ($routes as $route) {
            $request = \Illuminate\Http\Request::create($route['path'], $route['method']);
            $request->headers->set('Host', 'kortextools.test');

            $kernel = app('Illuminate\Contracts\Http\Kernel');
            $response = $kernel->handle($request);

            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 301, 302, 304]),
                "Route {$route['name']} ({$route['path']}) returned {$response->getStatusCode()}"
            );
        }
    }

    /**
     * Test that admin routes require authentication
     */
    public function test_admin_routes_protected(): void
    {
        $routes = [
            '/kortextools',
            '/kortextools/tools',
            '/kortextools/ratings',
        ];

        foreach ($routes as $path) {
            $request = \Illuminate\Http\Request::create($path, 'GET');
            $request->headers->set('Host', 'admin.africoders.test');

            $kernel = app('Illuminate\Contracts\Http\Kernel');
            $response = $kernel->handle($request);

            // Should redirect to login
            $this->assertTrue(
                in_array($response->getStatusCode(), [302, 307]),
                "Admin route $path should redirect unauthenticated requests (got {$response->getStatusCode()})"
            );
        }
    }
}
