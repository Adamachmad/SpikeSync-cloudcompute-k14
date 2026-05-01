<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Services Configuration
    |--------------------------------------------------------------------------
    |
    | Third-party API configurations used by the application
    |
    */

    'exercise_api' => [
        'key' => env('EXERCISE_DB_API_KEY'),
        'url' => env('EXERCISE_DB_API_URL', 'https://exercisedb.p.rapidapi.com'),
    ],

    'sports_api' => [
        'key' => env('SPORTS_API_KEY'),
        'url' => env('SPORTS_API_URL', 'https://api.api-sports.io'),
    ],
];
