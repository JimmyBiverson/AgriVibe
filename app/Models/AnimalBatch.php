<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'expected_end_date' => 'date',
        'average_weight_kg' => 'decimal:3',
        'target_fcr' => 'decimal:2',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function productionRecords(): HasMany
    {
        return $this->hasMany(ProductionRecord::class);
    }

    public function healthEvents(): HasMany
    {
        return $this->hasMany(HealthEvent::class);
    }

    public function finances(): HasMany
    {
        return $this->hasMany(FarmFinance::class);
    }

    public function getLivabilityPercentAttribute(): float
    {
        if ($this->initial_quantity <= 0) {
            return 100.0;
        }

        return round(($this->current_quantity / $this->initial_quantity) * 100, 1);
    }
}
