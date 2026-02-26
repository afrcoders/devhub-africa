<?php

namespace App\Http\Controllers\Africoders\Main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    public function home()
    {
        $domains = $this->getDomains();

        return view('africoders.main.home', [
            'domains' => $domains,
            'environment' => config('app.env'),
        ]);
    }

    private function getDomains()
    {
        $config = Config::get('domains');
        $flatDomains = [];
        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        // Africoders domains
        $flatDomains[] = [
            'name' => 'Africoders - Main Site',
            'url' => 'https://' . $config['africoders']['main'],
            'description' => 'The main Africoders landing page',
            'category' => 'Africoders',
        ];

        $flatDomains[] = [
            'name' => 'Africoders ID Service',
            'url' => 'https://' . $config['africoders']['id'],
            'description' => 'Authentication and user management',
            'category' => 'Africoders',
        ];

        // Only show API if user is admin
        if ($isAdmin) {
            $flatDomains[] = [
                'name' => 'Africoders API',
                'url' => 'https://' . $config['africoders']['api'] . '/api/health',
                'description' => 'RESTful API service',
                'category' => 'Africoders',
            ];
        }

        // Only show Admin if user is admin
        if ($isAdmin) {
            $flatDomains[] = [
                'name' => 'Africoders Admin',
                'url' => 'https://' . $config['africoders']['admin'],
                'description' => 'Admin control panel',
                'category' => 'Africoders',
            ];
        }

        $flatDomains[] = [
            'name' => 'Africoders Help',
            'url' => 'https://' . $config['africoders']['help'],
            'description' => 'Help center and documentation',
            'category' => 'Africoders',
        ];

        // Noccea domains
        $flatDomains[] = [
            'name' => 'Noccea - Main Site',
            'url' => 'https://' . $config['noccea']['main'],
            'description' => 'Noccea main site',
            'category' => 'Noccea',
        ];

        $flatDomains[] = [
            'name' => 'Noccea Community',
            'url' => 'https://' . $config['noccea']['community'],
            'description' => 'Community forum and discussion',
            'category' => 'Noccea',
        ];

        $flatDomains[] = [
            'name' => 'Noccea Business',
            'url' => 'https://' . $config['noccea']['business'],
            'description' => 'Business solutions and services',
            'category' => 'Noccea',
        ];

        $flatDomains[] = [
            'name' => 'Noccea Learn',
            'url' => 'https://' . $config['noccea']['learn'],
            'description' => 'Learning platform and courses',
            'category' => 'Noccea',
        ];

        // Kortex Tools
        $flatDomains[] = [
            'name' => 'Kortex Tools',
            'url' => 'https://' . $config['tools']['kortex'],
            'description' => 'Development tools and utilities',
            'category' => 'Tools',
        ];

        // Group by category
        $domains = [];
        foreach ($flatDomains as $domain) {
            $category = $domain['category'];
            if (!isset($domains[$category])) {
                $domains[$category] = [];
            }
            $domains[$category][] = $domain;
        }

        return $domains;
    }
}
