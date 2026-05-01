<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\PlayerStatistic;
use App\Models\Leaderboard;
use App\Models\Workout;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample users
        $user1 = User::create([
            'name' => 'Adam Achmad',
            'email' => 'adam@volleytrack.test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'plan_type' => 'pro',
            'trial_ends_at' => now()->addDays(7),
        ]);

        $user2 = User::create([
            'name' => 'John Coach',
            'email' => 'coach@volleytrack.test',
            'password' => bcrypt('password123'),
            'role' => 'coach',
            'plan_type' => 'pro',
            'trial_ends_at' => now()->addDays(14),
        ]);

        // Create sample teams
        $team1 = Team::create([
            'user_id' => $user1->id,
            'name' => 'Spike Masters',
            'description' => 'Tim voli profesional dari Jakarta',
            'plan_type' => 'pro',
            'is_active' => true,
        ]);

        $team2 = Team::create([
            'user_id' => $user2->id,
            'name' => 'Ace Warriors',
            'description' => 'Team voli kampus dari Bandung',
            'plan_type' => 'basic',
            'is_active' => true,
        ]);

        // Create sample players
        $players = [
            ['name' => 'Rinto Wibowo', 'position' => 'Setter', 'number' => 1],
            ['name' => 'Andrey Wibowo', 'position' => 'Outside Hitter', 'number' => 2],
            ['name' => 'Marko Milic', 'position' => 'Middle Blocker', 'number' => 3],
            ['name' => 'Ade Gunawan', 'position' => 'Opposite', 'number' => 4],
            ['name' => 'Teuku Rif\'at', 'position' => 'Libero', 'number' => 5],
            ['name' => 'Rivan Nurmulki', 'position' => 'Outside Hitter', 'number' => 6],
        ];

        foreach ($players as $key => $playerData) {
            Player::create([
                'team_id' => $team1->id,
                'user_id' => $user1->id,
                'name' => $playerData['name'],
                'position' => $playerData['position'],
                'number' => $playerData['number'],
                'height' => fake()->numberBetween(170, 200) . ' cm',
                'dominant_hand' => collect(['right', 'left'])->random(),
            ]);
        }

        // Create players untuk team 2
        for ($i = 0; $i < 6; $i++) {
            Player::create([
                'team_id' => $team2->id,
                'user_id' => $user2->id,
                'name' => fake()->name(),
                'position' => collect(['Setter', 'Outside Hitter', 'Middle Blocker', 'Opposite', 'Libero'])->random(),
                'number' => $i + 1,
                'height' => fake()->numberBetween(170, 200) . ' cm',
                'dominant_hand' => collect(['right', 'left'])->random(),
            ]);
        }

        // Create schedules
        Schedule::create([
            'team_id' => $team1->id,
            'title' => 'Latihan Reguler - Spike Masters',
            'description' => 'Sesi latihan reguler dengan fokus pada spike attack',
            'scheduled_at' => now()->addDays(1)->setHour(19),
            'status' => 'scheduled',
            'location' => 'Gelora Bung Karno, Jakarta',
        ]);

        Schedule::create([
            'team_id' => $team1->id,
            'title' => 'Pertandingan Uji Coba',
            'description' => 'Pertandingan uji coba melawan klub lokal',
            'scheduled_at' => now()->addDays(3)->setHour(18),
            'status' => 'scheduled',
            'location' => 'Istora Senayan',
        ]);

        // Create player statistics
        $team1Players = $team1->players;
        foreach ($team1Players as $player) {
            for ($i = 0; $i < 3; $i++) {
                PlayerStatistic::create([
                    'player_id' => $player->id,
                    'team_id' => $team1->id,
                    'match_id' => fake()->numberBetween(1, 10),
                    'spike_count' => fake()->numberBetween(5, 25),
                    'block_count' => fake()->numberBetween(0, 15),
                    'ace_count' => fake()->numberBetween(0, 10),
                    'pass_accuracy' => fake()->numberBetween(40, 95),
                    'set_count' => fake()->numberBetween(0, 20),
                    'dig_count' => fake()->numberBetween(0, 20),
                ]);
            }
        }

        // Create leaderboards
        $team1LeaderboardData = [];
        foreach ($team1Players as $rank => $player) {
            $totalStats = $player->statistics()->get();
            $totalPoints = 0;
            foreach ($totalStats as $stat) {
                $totalPoints += $stat->calculateTotalPoints();
            }

            Leaderboard::create([
                'team_id' => $team1->id,
                'player_id' => $player->id,
                'rank' => $rank + 1,
                'total_points' => $totalPoints,
                'total_spikes' => $totalStats->sum('spike_count'),
                'total_blocks' => $totalStats->sum('block_count'),
                'total_aces' => $totalStats->sum('ace_count'),
            ]);
        }

        // Create sample workouts
        $workoutsData = [
            [
                'name' => 'Vertical Jump',
                'description' => 'Latihan lompatan vertikal untuk meningkatkan reach',
                'equipment' => 'Bodyweight',
                'difficulty' => 'Intermediate',
                'target_muscle' => 'Legs',
                'external_id' => 'jump_001',
            ],
            [
                'name' => 'Shoulder Press',
                'description' => 'Latihan untuk kekuatan shoulder',
                'equipment' => 'Barbell',
                'difficulty' => 'Intermediate',
                'target_muscle' => 'Shoulders',
                'external_id' => 'shoulder_001',
            ],
            [
                'name' => 'Core Plank',
                'description' => 'Latihan stabilitas core',
                'equipment' => 'Bodyweight',
                'difficulty' => 'Beginner',
                'target_muscle' => 'Core',
                'external_id' => 'core_001',
            ],
            [
                'name' => 'Lateral Raise',
                'description' => 'Latihan isolasi bahu lateral',
                'equipment' => 'Dumbbell',
                'difficulty' => 'Beginner',
                'target_muscle' => 'Shoulders',
                'external_id' => 'lateral_001',
            ],
            [
                'name' => 'Squat',
                'description' => 'Latihan kaki fundamental',
                'equipment' => 'Barbell',
                'difficulty' => 'Intermediate',
                'target_muscle' => 'Legs',
                'external_id' => 'squat_001',
            ],
        ];

        foreach ($workoutsData as $workoutData) {
            Workout::create($workoutData);
        }

        $this->command->info('✅ Database seeding berhasil!');
    }
}
