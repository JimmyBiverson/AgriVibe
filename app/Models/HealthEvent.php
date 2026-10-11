<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthEvent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'administered_date' => 'date',
        'safe_consumption_date' => 'date',
        'withdrawal_period_days' => 'integer',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(AnimalBatch::class, 'animal_batch_id');
    }

    public function vet(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vet_id');
    }

    public function getIsWithdrawalActiveAttribute(): bool
    {
        if (! $this->safe_consumption_date) {
            return false;
        }

        return $this->safe_consumption_date->isFuture();
    }
}
