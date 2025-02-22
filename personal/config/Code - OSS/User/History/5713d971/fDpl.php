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

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'niubix' => [
        'merchant_id' => env('NIUBIX_MERCHANT_ID'),
        'user' => env('NIUBIX_USER'),
        'password' => env('NIUBIX_PASSWORD'),
        'url_api' => env('NIUBIX_URL_API'),
        'url_js' => env('NIUBIX_URL_JS'),
    ],

    'sunat' => [
        'token' => env('API_SUNAT_TOKEN'),
        'urldni' => env('API_SUNAT_URL_DNI'),
        'urlruc' => env('API_SUNAT_URL_RUC'),
    ],



];
