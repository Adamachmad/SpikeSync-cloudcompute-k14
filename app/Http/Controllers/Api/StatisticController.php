<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlayerStatistic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'team_id' => 'required|exists:teams,id',
            'match_id' => 'nullable|integer',
            'spike_count' => 'required|integer|min:0',
            'block_count' => 'required|integer|min:0',
            'ace_count' => 'required|integer|min:0',
            'pass_accuracy' => 'nullable|numeric|between:0,100',
            'set_count' => 'nullable|integer|min:0',
            'dig_count' => 'nullable|integer|min:0',
        ]);

        $statistic = PlayerStatistic::create($validated);

        return response()->json(['data' => $statistic], 201);
    }
}
