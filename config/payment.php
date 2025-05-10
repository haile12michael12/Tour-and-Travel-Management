<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    */
    'default' => 'stripe',
    
    /*
    |--------------------------------------------------------------------------
    | Payment Gateways Configuration
    |--------------------------------------------------------------------------
    */
    'gateways' => [
        'stripe' => [
            'public_key' => env('STRIPE_PUBLIC_KEY'),
            'secret_key' => env('STRIPE_SECRET_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            'currency' => 'usd',
            'mode' => 'test', // test or live
        ],
        
        'paypal' => [
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
            'mode' => 'sandbox', // sandbox or live
            'currency' => 'USD',
        ],
        
        'razorpay' => [
            'key_id' => env('RAZORPAY_KEY_ID'),
            'key_secret' => env('RAZORPAY_KEY_SECRET'),
            'currency' => 'INR',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */
    'settings' => [
        'currency' => 'USD',
        'currency_symbol' => '$',
        'decimal_separator' => '.',
        'thousand_separator' => ',',
        'decimal_places' => 2,
        
        'tax_rate' => 0.10, // 10%
        'service_fee' => 0.05, // 5%
        
        'refund_policy' => [
            'allowed_days' => 7,
            'processing_fee' => 0.02, // 2%
        ],
        
        'commission' => [
            'booking' => 0.15, // 15%
            'tour' => 0.20, // 20%
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    */
    'methods' => [
        'credit_card' => [
            'enabled' => true,
            'min_amount' => 1,
            'max_amount' => 10000,
        ],
        'paypal' => [
            'enabled' => true,
            'min_amount' => 1,
            'max_amount' => 10000,
        ],
        'bank_transfer' => [
            'enabled' => true,
            'min_amount' => 100,
            'max_amount' => 50000,
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Payment Notifications
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'email' => [
            'enabled' => true,
            'template' => 'emails.payment',
        ],
        'sms' => [
            'enabled' => false,
            'provider' => 'twilio',
        ],
    ],
]; 