<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $equipment
 * @property string $difficulty
 * @property string $target_muscle
 * @property string $external_id
 * @property timestamps
 */
class Workout extends Model
{
    protected $fillable = [
        'name',
        'description',
        'equipment',
        'difficulty',
        'target_muscle',
        'external_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
