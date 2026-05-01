<?php

namespace App\Http\Controllers\Workouts;

use App\Models\Workout;
use Illuminate\View\View;
use App\Services\ExerciseApiService;

class WorkoutController
{
    /**
     * Display all cached workouts
     */
    public function index(): View
    {
        $workouts = Workout::paginate(20);
        return view('workouts.index', compact('workouts'));
    }

    /**
     * Show recommended workouts for volleyball
     */
    public function recommended(): View
    {
        $workouts = Workout::where('target_muscle', '!=', null)
            ->paginate(20);

        return view('workouts.recommended', compact('workouts'));
    }
}
