<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disease extends Model
{
    protected $fillable = [
        'species_id', 'name', 'slug', 'category', 'cause', 'symptoms', 'prevention',
        'treatment', 'severity', 'is_notifiable', 'is_contagious', 'image',
        'is_expert_verified', 'disclaimer', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_notifiable' => 'boolean',
            'is_contagious' => 'boolean',
            'is_expert_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function symptoms(): BelongsToMany
    {
        return $this->belongsToMany(Symptom::class);
    }
}
