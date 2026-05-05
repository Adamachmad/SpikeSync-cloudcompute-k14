<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    public function index(): JsonResponse
    {
        $leaderboard = Leaderboard::orderBy('rank')->get();

        return response()->json(['data' => $leaderboard]);
    }
}
