<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Species extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'species';

    protected $fillable = [
        'enterprise_type_id', 'name', 'slug', 'kingdom', 'category', 'scientific_name',
        'description', 'image', 'gestation_days', 'incubation_days', 'maturity_weeks',
        'is_active', 'sort',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function enterpriseType(): BelongsTo
    {
        return $this->belongsTo(EnterpriseType::class);
    }

    public function breeds(): HasMany
    {
        return $this->hasMany(Breed::class);
    }

    public function diseases(): HasMany
    {
        return $this->hasMany(Disease::class);
    }
}
