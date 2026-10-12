<?php

namespace App\Models;

use App\Models\Concerns\GeneratesPublicId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Farm extends Model implements HasMedia
{
    use GeneratesPublicId, HasFactory, InteractsWithMedia, LogsActivity, SoftDeletes;

    protected $fillable = [
        'owner_id', 'name', 'slug', 'type', 'country_code', 'location_id', 'district',
        'sub_county', 'parish', 'village', 'address', 'latitude', 'longitude', 'acreage',
        'land_tenure', 'description', 'logo', 'cover_image', 'water_sources', 'has_electricity',
        'infrastructure', 'workers_count', 'emergency_contacts', 'assigned_vet_id',
        'preferred_language', 'preferred_contact', 'visibility', 'status', 'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'water_sources' => 'array',
            'emergency_contacts' => 'array',
            'has_electricity' => 'boolean',
            'acreage' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'verified_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontLogEmptyChanges();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function assignedVet(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_vet_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(FarmMember::class);
    }

    public function enterprises(): HasMany
    {
        return $this->hasMany(FarmEnterprise::class);
    }
}
