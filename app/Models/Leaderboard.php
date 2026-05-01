<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $team_id
 * @property int $player_id
 * @property int $rank
 * @property int $total_points
 * @property int $total_spikes
 * @property int $total_blocks
 * @property int $total_aces
 * @property timestamps
 */
class Leaderboard extends Model
{
    protected $table = 'leaderboards';

    protected $fillable = [
        'team_id',
        'player_id',
        'rank',
        'total_points',
        'total_spikes',
        'total_blocks',
        'total_aces',
    ];

    protected $casts = [
        'rank' => 'integer',
        'total_points' => 'integer',
        'total_spikes' => 'integer',
        'total_blocks' => 'integer',
        'total_aces' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
