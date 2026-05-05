<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\LandingPageController;
use App\Http\Controllers\Pages\PricingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
