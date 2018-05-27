<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'oauth' => [
        'client_name' => env('CLIENT_NAME',''),
        'client_id' => env('CLIENT_ID', ''),
        'client_secret' => env('CLIENT_SECRET', ''),
        'redirect' => env('REDIRECT', '/auth/oauth-callback'),
        'scopes' => env('OAUTH_SCOPES', '*'),
        'authorize_url' => env('OAUTH_AUTH_URL', '/oauth/authorize'),
        'token_url' => env('OAUTH_TOKEN_URL', '/oauth/authorize'),
        'userinfo_url' => env('OAUTH_USERINFO_URL','/oauth/authorize'),
        
    ],
];
