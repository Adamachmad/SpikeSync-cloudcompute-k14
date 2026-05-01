<?php

namespace App\Http\Controllers\Leaderboards;

use App\Models\Leaderboard;
use App\Models\Team;
use Illuminate\View\View;

class LeaderboardController
{
    /**
     * Display global leaderboard
     */
    public function index(): View
    {
        $leaderboard = Leaderboard::with(['player', 'team'])
            ->orderBy('rank', 'asc')
            ->paginate(50);

        return view('leaderboards.index', compact('leaderboard'));
    }

    /**
     * Display team leaderboard
     */
    public function teamLeaderboard(Team $team): View
    {
        $leaderboard = $team->leaderboard()
            ->with('player')
            ->orderBy('rank', 'asc')
            ->paginate(50);

        return view('leaderboards.team', compact('team', 'leaderboard'));
    }
}
