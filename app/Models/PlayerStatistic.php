<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $player_id
 * @property int $team_id
 * @property int $match_id
 * @property int $spike_count
 * @property int $block_count
 * @property int $ace_count
 * @property float $pass_accuracy
 * @property int $set_count
 * @property int $dig_count
 * @property timestamps
 */
class PlayerStatistic extends Model
{
    protected $table = 'player_statistics';

    protected $fillable = [
        'player_id',
        'team_id',
        'match_id',
        'spike_count',
        'block_count',
        'ace_count',
        'pass_accuracy',
        'set_count',
        'dig_count',
    ];

    protected $casts = [
        'spike_count' => 'integer',
        'block_count' => 'integer',
        'ace_count' => 'integer',
        'pass_accuracy' => 'float',
        'set_count' => 'integer',
        'dig_count' => 'integer',
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

    /**
     * Calculate total points based on statistics
     */
    public function calculateTotalPoints(): int
    {
        return ($this->spike_count * 2) + 
               ($this->block_count * 3) + 
               ($this->ace_count * 5) + 
               (int)($this->pass_accuracy) + 
               ($this->set_count * 1) + 
               ($this->dig_count * 1);
    }
}
