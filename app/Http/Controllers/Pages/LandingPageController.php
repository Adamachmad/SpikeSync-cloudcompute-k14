<?php

namespace App\Http\Controllers\Pages;

use Illuminate\View\View;

class LandingPageController
{
    /**
     * Show the landing page
     */
    public function index(): View
    {
        return view('pages.landing');
    }
}
