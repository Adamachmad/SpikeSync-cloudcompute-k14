<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExerciseApiService
{
    protected $apiKey;
    protected $apiUrl;
    protected $headers;

    public function __construct()
    {
        $this->apiKey = config('services.exercise_api.key');
        $this->apiUrl = config('services.exercise_api.url');
        
        $this->headers = [
            'x-rapidapi-key' => $this->apiKey,
            'x-rapidapi-host' => 'exercisedb.p.rapidapi.com',
        ];
    }

    /**
     * Fetch volleyball-related workouts from external API
     * 
     * @param int $limit
     * @return array
     */
    public function fetchVolleyworkouts(int $limit = 50): array
    {
        try {
            // Target muscles for volleyball players
            $targetMuscles = ['legs', 'shoulders', 'core', 'arms', 'back'];
            $workouts = [];

            foreach ($targetMuscles as $muscle) {
                $response = Http::withHeaders($this->headers)
                    ->timeout(30)
                    ->get("{$this->apiUrl}/exercises/target/{$muscle}");

                if ($response->successful()) {
                    $data = $response->json();
                    $workouts = array_merge($workouts, $data);
                }

                if (count($workouts) >= $limit) {
                    break;
                }
            }

            // Format response
            return array_map(fn($item) => [
                'id' => $item['id'] ?? uniqid(),
                'name' => $item['name'] ?? 'Unknown Exercise',
                'description' => $item['description'] ?? null,
                'equipment' => $item['equipment'] ?? null,
                'difficulty' => $item['difficulty'] ?? 'medium',
                'target_muscle' => $item['target'] ?? null,
            ], array_slice($workouts, 0, $limit));

        } catch (\Exception $e) {
            Log::error('ExerciseAPI Error', [
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Get single workout detail
     */
    public function getWorkoutDetail(string $workoutId): ?array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout(30)
                ->get("{$this->apiUrl}/exercises/{$workoutId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Get Workout Detail Error', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Search workouts by name
     */
    public function searchWorkouts(string $query): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout(30)
                ->get("{$this->apiUrl}/exercises/name/{$query}");

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];

        } catch (\Exception $e) {
            Log::error('Search Workouts Error', [
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
