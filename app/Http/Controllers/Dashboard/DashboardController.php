<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Schedule;
use App\Models\PlayerStatistic;
use App\Models\Leaderboard;

class DashboardController
{
    /**
     * Show the dashboard
     */
    public function index(): View
    {
        $user = Auth::user();
        $teams = $user->teams()->get();
        
        $upcomingSchedules = Schedule::whereIn('team_id', $teams->pluck('id'))
            ->upcoming()
            ->take(5)
            ->get();
        
        $recentStats = PlayerStatistic::whereIn('team_id', $teams->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $data = [
            'teams_count' => $teams->count(),
            'players_count' => $teams->sum(fn($team) => $team->players()->count()),
            'upcoming_schedules' => $upcomingSchedules,
            'recent_statistics' => $recentStats,
            'user_plan' => $user->plan_type,
        ];

        return view('dashboard', $data);
    }
}
