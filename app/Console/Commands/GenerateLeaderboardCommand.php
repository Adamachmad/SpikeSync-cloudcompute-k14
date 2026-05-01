<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Player;
use App\Models\Leaderboard;
use App\Models\Team;

class GenerateLeaderboardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volley:generate-leaderboard
                            {--team_id= : Generate leaderboard untuk team tertentu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dan update leaderboard ranking berdasarkan statistik pemain';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🏆 Memulai generate leaderboard...');

        try {
            $teamId = $this->option('team_id');
            
            if ($teamId) {
                $teams = Team::where('id', $teamId)->get();
                if ($teams->isEmpty()) {
                    $this->error("❌ Team dengan ID {$teamId} tidak ditemukan");
                    return self::FAILURE;
                }
            } else {
                $teams = Team::all();
            }

            $totalUpdated = 0;

            foreach ($teams as $team) {
                $this->info("📊 Memproses leaderboard untuk team: {$team->name}");
                
                $players = $team->players()->with(['statistics'])->get();
                $rank = 1;

                foreach ($players as $player) {
                    // Calculate total points from all statistics
                    $stats = $player->statistics;
                    
                    $totalPoints = 0;
                    $totalSpikes = 0;
                    $totalBlocks = 0;
                    $totalAces = 0;

                    foreach ($stats as $stat) {
                        $totalPoints += $stat->calculateTotalPoints();
                        $totalSpikes += $stat->spike_count;
                        $totalBlocks += $stat->block_count;
                        $totalAces += $stat->ace_count;
                    }

                    // Update atau create leaderboard entry
                    Leaderboard::updateOrCreate(
                        [
                            'team_id' => $team->id,
                            'player_id' => $player->id,
                        ],
                        [
                            'rank' => $rank++,
                            'total_points' => $totalPoints,
                            'total_spikes' => $totalSpikes,
                            'total_blocks' => $totalBlocks,
                            'total_aces' => $totalAces,
                        ]
                    );

                    $totalUpdated++;
                }

                $this->info("✅ Team '{$team->name}' leaderboard diperbarui ({$players->count()} pemain)");
            }

            $this->info("🎉 Total {$totalUpdated} leaderboard entries berhasil di-update");
            $this->table(
                ['Total Players Updated', 'Total Teams', 'Timestamp'],
                [[$totalUpdated, $teams->count(), now()->format('Y-m-d H:i:s')]]
            );

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            \Log::error('Generate Leaderboard Command Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return self::FAILURE;
        }
    }
}
