<?php

return [

    'portal' => env('PORTAL_DOMAIN', 'portal.africoders.test'),

    'africoders' => [
        'main' => env('AFRICODERS_DOMAIN'),
        'admin' => env('AFRICODERS_ADMIN_DOMAIN'),
        'api' => env('AFRICODERS_API_DOMAIN'),
        'id' => env('AFRICODERS_ID_DOMAIN'),
        'help' => env('AFRICODERS_HELP_DOMAIN'),
    ],

    'noccea' => [
        'main' => env('NOCCEA_DOMAIN'),
        'community' => env('NOCCEA_COMMUNITY_DOMAIN'),
        'business' => env('NOCCEA_BUSINESS_DOMAIN'),
        'learn' => env('NOCCEA_LEARN_DOMAIN'),
    ],

    'tools' => [
        'kortex' => env('KORTEXTOOLS_DOMAIN'),
    ],

    // Site names for each domain
    'site_names' => [
        'portal.africoders.test' => 'Africoders Portal',
        'portal.africoders.com' => 'Africoders Portal',
        'africoders.test' => 'Africoders',
        'africoders.com' => 'Africoders',
        'admin.africoders.test' => 'Africoders Admin',
        'admin.africoders.com' => 'Africoders Admin',
        'api.africoders.test' => 'Africoders API',
        'api.africoders.com' => 'Africoders API',
        'id.africoders.test' => 'Africoders ID',
        'id.africoders.com' => 'Africoders ID',
        'help.africoders.test' => 'Africoders Help',
        'help.africoders.com' => 'Africoders Help',
        'noccea.test' => 'Noccea',
        'noccea.com' => 'Noccea',
        'community.noccea.test' => 'Noccea Community',
        'community.noccea.com' => 'Noccea Community',
        'business.noccea.test' => 'Noccea Business',
        'business.noccea.com' => 'Noccea Business',
        'learn.noccea.test' => 'Noccea Learn',
        'learn.noccea.com' => 'Noccea Learn',
        'kortextools.test' => 'Kortex Tools',
        'kortextools.com' => 'Kortex Tools',
    ],

    // Trusted domains for return URL validation
    'trusted_domains' => [
        'africoders.test',
        '.africoders.test',
        'africoders.com',
        '.africoders.com',
        'noccea.test',
        '.noccea.test',
        'noccea.com',
        '.noccea.com',
        'kortextools.test',
        '.kortextools.test',
        'kortextools.com',
        '.kortextools.com',
    ],

];
