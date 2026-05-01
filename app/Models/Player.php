<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property string $name
 * @property string $position
 * @property int $number
 * @property string $height
 * @property string $dominant_hand
 * @property timestamps
 */
class Player extends Model
{
    protected $fillable = [
        'team_id',
        'user_id',
        'name',
        'position',
        'number',
        'height',
        'dominant_hand',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(PlayerStatistic::class);
    }

    public function leaderboard()
    {
        return $this->hasOne(Leaderboard::class);
    }
}
