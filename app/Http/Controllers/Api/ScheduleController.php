<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    public function index(): JsonResponse
    {
        $schedules = Schedule::with('team')->orderBy('scheduled_at', 'asc')->get();

        return response()->json(['data' => $schedules]);
    }
}
