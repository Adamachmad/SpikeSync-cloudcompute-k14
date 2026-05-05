<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\WorkoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API endpoints for frontend consumption
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index']);
    Route::post('/statistics', [StatisticController::class, 'store']);
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/workouts', [WorkoutController::class, 'index']);
});
