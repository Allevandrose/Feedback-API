<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Apply to API routes & CSRF for Sanctum

    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, etc.)

    'allowed_origins' => ['*'], // Allow all origins (set specific domains if needed)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],

    'exposed_headers' => [],

    'max_age' => 0, // No caching for preflight requests

    'supports_credentials' => true, // Allow credentials (e.g., cookies, auth headers)
];

