<?php

namespace App\Http\Controllers\Pages;

use Illuminate\View\View;

class PricingController
{
    /**
     * Show pricing page
     */
    public function index(): View
    {
        $plans = [
            [
                'name' => 'Basic',
                'price' => config('app.pricing_basic_price', 29900),
                'billing_period' => '/bulan',
                'description' => 'Untuk pemain individual',
                'features' => [
                    'Schedule Management',
                    'Personal Statistics',
                    'Workout Recommendations',
                    'Email Support',
                ],
                'is_popular' => false,
                'cta_text' => 'Mulai Trial Gratis',
            ],
            [
                'name' => 'Pro',
                'price' => config('app.pricing_pro_price', 99900),
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
                'is_popular' => true,
                'cta_text' => 'Mulai Trial Gratis',
            ],
        ];

        return view('pages.pricing', ['plans' => $plans]);
    }
}
