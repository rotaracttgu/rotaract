<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure CORS settings for your application.
    | For detailed information, see the official Laravel documentation:
    | https://laravel.com/docs/11.x/routing#cors
    |
    */

    'paths' => ['api/*', '*/api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // Development environments
        'http://localhost',
        'http://127.0.0.1',
        'http://localhost:3000',
        'http://localhost:8000',
        'http://127.0.0.1:8000',
        
        // Add your production domain here when deployed:
        // 'https://yourdomain.com',
        // 'https://www.yourdomain.com',
    ],

    'allowed_origins_patterns' => [
        // Pattern for localhost with ports:
        '#^http:\/\/localhost(:[0-9]+)?$#',
        '#^http:\/\/127\.0\.0\.1(:[0-9]+)?$#',
        
        // Uncomment for production environment pattern:
        // '#^https:\/\/(www\.)?yourdomain\.com$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
