<?php

namespace App\Http\Controllers\Players;

use App\Models\Player;
use App\Models\PlayerStatistic;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlayerStatisticController
{
    /**
     * Display all statistics
     */
    public function index(): View
    {
        $user = auth()->user();
        $statistics = PlayerStatistic::whereIn('team_id', $user->teams->pluck('id'))
            ->with('player', 'team')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('statistics.index', compact('statistics'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $teams = auth()->user()->teams;
        return view('statistics.create', compact('teams'));
    }

    /**
     * Store new statistic
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'player_id' => ['required', 'exists:players,id'],
            'team_id' => ['required', 'exists:teams,id'],
            'spike_count' => ['required', 'integer', 'min:0'],
            'block_count' => ['required', 'integer', 'min:0'],
            'ace_count' => ['required', 'integer', 'min:0'],
            'pass_accuracy' => ['required', 'numeric', 'min:0', 'max:100'],
            'set_count' => ['required', 'integer', 'min:0'],
            'dig_count' => ['required', 'integer', 'min:0'],
        ]);

        PlayerStatistic::create($validated);

        return redirect()->route('statistics.index')
            ->with('success', 'Statistik pemain berhasil disimpan');
    }

    /**
     * Show player statistics
     */
    public function playerStats(Player $player): View
    {
        $statistics = $player->statistics()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalStats = [
            'total_spikes' => $player->statistics()->sum('spike_count'),
            'total_blocks' => $player->statistics()->sum('block_count'),
            'total_aces' => $player->statistics()->sum('ace_count'),
            'avg_pass_accuracy' => $player->statistics()->avg('pass_accuracy'),
        ];

        return view('statistics.player', compact('player', 'statistics', 'totalStats'));
    }

    /**
     * Show statistic details
     */
    public function show(PlayerStatistic $statistic): View
    {
        return view('statistics.show', compact('statistic'));
    }

    /**
     * Edit form
     */
    public function edit(PlayerStatistic $statistic): View
    {
        return view('statistics.edit', compact('statistic'));
    }

    /**
     * Update statistic
     */
    public function update(Request $request, PlayerStatistic $statistic): RedirectResponse
    {
        $validated = $request->validate([
            'spike_count' => ['required', 'integer', 'min:0'],
            'block_count' => ['required', 'integer', 'min:0'],
            'ace_count' => ['required', 'integer', 'min:0'],
            'pass_accuracy' => ['required', 'numeric', 'min:0', 'max:100'],
            'set_count' => ['required', 'integer', 'min:0'],
            'dig_count' => ['required', 'integer', 'min:0'],
        ]);

        $statistic->update($validated);

        return redirect()->route('statistics.show', $statistic)
            ->with('success', 'Statistik berhasil diperbarui');
    }

    /**
     * Delete statistic
     */
    public function destroy(PlayerStatistic $statistic): RedirectResponse
    {
        $statistic->delete();

        return redirect()->route('statistics.index')
            ->with('success', 'Statistik berhasil dihapus');
    }
}
