<?php

namespace App\Models;

use App\Models\Concerns\GeneratesPublicId;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasMedia, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use GeneratesPublicId, HasFactory, HasRoles, InteractsWithMedia, LogsActivity, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password', 'account_type', 'status',
        'avatar', 'referral_code', 'referred_by', 'is_verified', 'verified_at',
        'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at',
        'email_verified_at', 'phone_verified_at', 'last_login_at', 'last_login_ip',
        'onboarding_completed_at', 'preferences',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'last_login_at' => 'datetime',
            'onboarding_completed_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'preferences' => 'array',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontLogEmptyChanges();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('documents');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin', 'admin'])
            || in_array($this->account_type, ['admin', 'super_admin'], true);
    }

    public function isStaff(): bool
    {
        return $this->hasAnyRole(['super_admin', 'admin']);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function ownedFarms(): HasMany
    {
        return $this->hasMany(Farm::class, 'owner_id');
    }

    public function farmMemberships(): HasMany
    {
        return $this->hasMany(FarmMember::class);
    }

    public function farms(): BelongsToMany
    {
        return $this->belongsToMany(Farm::class, 'farm_members')
            ->withPivot(['role', 'status', 'permissions'])
            ->withTimestamps();
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(self::class, 'referred_by');
    }

    public function loginHistories(): HasMany
    {
        return $this->hasMany(LoginHistory::class);
    }
}
