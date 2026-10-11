<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccine extends Model
{
    protected $fillable = [
        'species_id', 'disease_id', 'name', 'slug', 'manufacturer', 'description',
        'dosage', 'route', 'withdrawal_days_meat', 'withdrawal_days_milk',
        'withdrawal_days_eggs', 'storage', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class);
    }
}
