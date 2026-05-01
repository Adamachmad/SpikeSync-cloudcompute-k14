<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API endpoints for frontend consumption
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/schedules', 'Api\ScheduleController@index');
    Route::post('/statistics', 'Api\StatisticController@store');
    Route::get('/leaderboard', 'Api\LeaderboardController@index');
    Route::get('/workouts', 'Api\WorkoutController@index');
});
