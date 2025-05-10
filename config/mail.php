<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mail Driver
    |--------------------------------------------------------------------------
    */
    'driver' => 'smtp',
    
    /*
    |--------------------------------------------------------------------------
    | SMTP Host Address
    |--------------------------------------------------------------------------
    */
    'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
    
    /*
    |--------------------------------------------------------------------------
    | SMTP Host Port
    |--------------------------------------------------------------------------
    */
    'port' => env('MAIL_PORT', 2525),
    
    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@tourandtravel.com'),
        'name' => env('MAIL_FROM_NAME', 'Tour and Travel Management'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | E-Mail Encryption Protocol
    |--------------------------------------------------------------------------
    */
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    
    /*
    |--------------------------------------------------------------------------
    | SMTP Server Username
    |--------------------------------------------------------------------------
    */
    'username' => env('MAIL_USERNAME'),
    
    /*
    |--------------------------------------------------------------------------
    | SMTP Server Password
    |--------------------------------------------------------------------------
    */
    'password' => env('MAIL_PASSWORD'),
    
    /*
    |--------------------------------------------------------------------------
    | Email Templates
    |--------------------------------------------------------------------------
    */
    'templates' => [
        'welcome' => [
            'subject' => 'Welcome to Tour and Travel Management',
            'template' => 'emails.welcome',
            'variables' => ['name', 'verification_link'],
        ],
        
        'booking_confirmation' => [
            'subject' => 'Booking Confirmation - Tour and Travel Management',
            'template' => 'emails.booking_confirmation',
            'variables' => ['booking_id', 'customer_name', 'tour_details', 'payment_details'],
        ],
        
        'payment_confirmation' => [
            'subject' => 'Payment Confirmation - Tour and Travel Management',
            'template' => 'emails.payment_confirmation',
            'variables' => ['payment_id', 'amount', 'booking_details'],
        ],
        
        'password_reset' => [
            'subject' => 'Password Reset Request - Tour and Travel Management',
            'template' => 'emails.password_reset',
            'variables' => ['reset_link', 'expiry_time'],
        ],
        
        'booking_reminder' => [
            'subject' => 'Upcoming Tour Reminder - Tour and Travel Management',
            'template' => 'emails.booking_reminder',
            'variables' => ['booking_details', 'tour_date', 'meeting_point'],
        ],
        
        'newsletter' => [
            'subject' => 'Latest Travel Deals and Updates',
            'template' => 'emails.newsletter',
            'variables' => ['deals', 'destinations', 'unsubscribe_link'],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Email Queue Settings
    |--------------------------------------------------------------------------
    */
    'queue' => [
        'enabled' => true,
        'connection' => 'default',
        'queue' => 'emails',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Email Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => true,
        'path' => storage_path('logs/mail.log'),
    ],
]; 