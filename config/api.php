<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Basic Info
    |--------------------------------------------------------------------------
    */
    'name' => env('APP_NAME', 'laravel-api'),

    'version' => env('APP_API_VERSION', '1.0.0'),

    'deprecated' => env('APP_API_DEPRECATED', false),

    'description' => env('APP_API_DESCRIPTION', ''),

    /*
    |--------------------------------------------------------------------------
    | API Maintainer
    |--------------------------------------------------------------------------
    */
    'maintainer' => [
        'name'  => env('APP_API_MAINTAINER', ''),
        'email' => env('APP_API_CONTACT_EMAIL', ''),
    ],

    'environment' => env('APP_ENV', 'production'),
];
