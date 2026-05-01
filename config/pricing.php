<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Pricing Configuration
    |--------------------------------------------------------------------------
    |
    | Pricing configuration for SaaS subscription plans
    |
    */

    'basic_price' => env('PRICING_BASIC_PRICE', 29900),
    'pro_price' => env('PRICING_PRO_PRICE', 99900),
    'trial_days' => env('TRIAL_DAYS', 7),

    'plans' => [
        'basic' => [
            'name' => 'Basic',
            'price' => env('PRICING_BASIC_PRICE', 29900),
            'billing_period' => '/bulan',
            'description' => 'Untuk pemain individual',
            'features' => [
                'Schedule Management',
                'Personal Statistics',
                'Workout Recommendations',
                'Email Support',
            ],
        ],
        'pro' => [
            'name' => 'Pro',
            'price' => env('PRICING_PRO_PRICE', 99900),
            'billing_period' => '/bulan',
            'description' => 'Untuk manajemen tim profesional',
            'features' => [
                'Semua fitur Basic',
                'Team Management',
                'Global Leaderboard',
                'Advanced Statistics',
                'API Access',
                'Priority Support',
            ],
        ],
    ],
];
