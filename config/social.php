<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Social Media Platforms Configuration
    |--------------------------------------------------------------------------
    */
    'platforms' => [
        'facebook' => [
            'enabled' => true,
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'redirect' => '/auth/facebook/callback',
            'scopes' => ['email', 'public_profile'],
        ],
        
        'google' => [
            'enabled' => true,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect' => '/auth/google/callback',
            'scopes' => ['email', 'profile'],
        ],
        
        'twitter' => [
            'enabled' => true,
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'redirect' => '/auth/twitter/callback',
        ],
        
        'linkedin' => [
            'enabled' => true,
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'redirect' => '/auth/linkedin/callback',
            'scopes' => ['r_liteprofile', 'r_emailaddress'],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Social Sharing Configuration
    |--------------------------------------------------------------------------
    */
    'sharing' => [
        'enabled' => true,
        'platforms' => [
            'facebook' => [
                'enabled' => true,
                'app_id' => env('FACEBOOK_APP_ID'),
            ],
            'twitter' => [
                'enabled' => true,
                'via' => 'tourandtravel',
            ],
            'linkedin' => [
                'enabled' => true,
            ],
            'whatsapp' => [
                'enabled' => true,
            ],
            'email' => [
                'enabled' => true,
            ],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Social Media Feeds
    |--------------------------------------------------------------------------
    */
    'feeds' => [
        'enabled' => true,
        'cache_time' => 3600, // 1 hour
        'platforms' => [
            'instagram' => [
                'enabled' => true,
                'username' => 'tourandtravel',
                'count' => 6,
            ],
            'twitter' => [
                'enabled' => true,
                'username' => 'tourandtravel',
                'count' => 5,
            ],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Social Media Analytics
    |--------------------------------------------------------------------------
    */
    'analytics' => [
        'enabled' => true,
        'platforms' => [
            'facebook' => [
                'pixel_id' => env('FACEBOOK_PIXEL_ID'),
            ],
            'google' => [
                'analytics_id' => env('GOOGLE_ANALYTICS_ID'),
            ],
        ],
    ],
]; 