<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $team_id
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $scheduled_at
 * @property string $status
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Schedule extends Model
{
    protected $fillable = [
        'team_id',
        'title',
        'description',
        'scheduled_at',
        'status',
        'location',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>=', now())
                     ->orderBy('scheduled_at', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('scheduled_at', '<', now())
                     ->orderBy('scheduled_at', 'desc');
    }
}
