<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccinationSchedule extends Model
{
    protected $fillable = [
        'species_id', 'vaccine_id', 'name', 'age_days_from', 'age_days_to', 'age_label',
        'route', 'dose', 'frequency', 'production_system', 'notes',
        'is_expert_verified', 'disclaimer', 'source', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_expert_verified' => 'boolean', 'is_active' => 'boolean'];
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }
}
