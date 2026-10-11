<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'gender', 'date_of_birth', 'bio', 'organization', 'job_title',
        'phone_alt', 'location_id', 'address', 'country_code', 'preferred_language',
        'preferred_contact', 'timezone', 'website', 'socials',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'socials' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
