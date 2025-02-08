<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'script_url' => env('GOOGLE_SCRIPT_URL', 'https://script.google.com/macros/s/AKfycbw4S94UNdr0yfZ36y1-5_qOGA23EAz0F-BhgdIMapcKWF7OkyGsCoLNoh_mLg-N81fhzA/exec'),
        'recaptcha'=>[
            'site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY', '6LeJSpgqAAAAANsT2GsY4aw5zQCtpz1VW7vgBxFE'),
            'secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY', '6LeJSpgqAAAAANq4ACk6YAZOhq1KlLzeh_SZ5FhX'),
        ]
    ]
];
