<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExerciseApiService;
use App\Models\Workout;

class FetchWorkoutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volley:fetch-workout
                            {--force : Force refresh cache}
                            {--limit=50 : Limit number of workouts to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch workout recommendations dari REST API pihak ketiga dan simpan ke database';

    protected $exerciseService;

    public function __construct(ExerciseApiService $exerciseService)
    {
        parent::__construct();
        $this->exerciseService = $exerciseService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🏐 Memulai fetch workout data dari External API...');
        
        try {
            $force = $this->option('force');
            $limit = $this->option('limit');
            
            // Check cache jika tidak force
            if (!$force && cache()->has('last_workout_fetch')) {
                $this->warn('⚠️  Data workout sudah di-cache. Gunakan --force untuk refresh');
                return self::SUCCESS;
            }

            $this->info("📥 Mengambil {$limit} workout data...");
            
            $workouts = $this->exerciseService->fetchVolleyworkouts($limit);
            
            if (empty($workouts)) {
                $this->warn('⚠️  Tidak ada data workout yang didapat dari API');
                return self::FAILURE;
            }

            // Save to database
            $saved = 0;
            foreach ($workouts as $workoutData) {
                Workout::updateOrCreate(
                    ['external_id' => $workoutData['id']],
                    [
                        'name' => $workoutData['name'],
                        'description' => $workoutData['description'] ?? null,
                        'equipment' => $workoutData['equipment'] ?? null,
                        'difficulty' => $workoutData['difficulty'] ?? 'medium',
                        'target_muscle' => $workoutData['target_muscle'] ?? null,
                    ]
                );
                $saved++;
            }

            // Set cache untuk 5 jam
            cache()->put('last_workout_fetch', now(), now()->addHours(5));

            $this->info("✅ Berhasil menyimpan {$saved} workout data ke database");
            $this->table(
                ['Total Workouts', 'Timestamp'],
                [[count($workouts), now()->format('Y-m-d H:i:s')]]
            );

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            \Log::error('Fetch Workout Command Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return self::FAILURE;
        }
    }
}
