<?php

namespace App\Http\Controllers\Schedules;

use App\Models\Schedule;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ScheduleController
{
    /**
     * Display all schedules
     */
    public function index(): View
    {
        $user = auth()->user();
        $schedules = Schedule::whereIn('team_id', $user->teams->pluck('id'))
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);

        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show create schedule form
     */
    public function create(): View
    {
        $teams = auth()->user()->teams;
        return view('schedules.create', compact('teams'));
    }

    /**
     * Store new schedule
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['required', 'date_format:Y-m-d H:i'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal latihan berhasil dibuat');
    }

    /**
     * Show schedule details
     */
    public function show(Schedule $schedule): View
    {
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show edit form
     */
    public function edit(Schedule $schedule): View
    {
        $teams = auth()->user()->teams;
        return view('schedules.edit', compact('schedule', 'teams'));
    }

    /**
     * Update schedule
     */
    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['required', 'date_format:Y-m-d H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:scheduled,ongoing,completed,cancelled'],
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.show', $schedule)
            ->with('success', 'Jadwal latihan berhasil diperbarui');
    }

    /**
     * Delete schedule
     */
    public function destroy(Schedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal latihan berhasil dihapus');
    }
}
