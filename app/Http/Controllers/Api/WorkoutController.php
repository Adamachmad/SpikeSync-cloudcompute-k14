<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\JsonResponse;

class WorkoutController extends Controller
{
    public function index(): JsonResponse
    {
        $workouts = Workout::all();

        return response()->json(['data' => $workouts]);
    }
}
