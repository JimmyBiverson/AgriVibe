<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'description', 'dosage', 'route',
        'withdrawal_days_meat', 'withdrawal_days_milk', 'withdrawal_days_eggs',
        'notes', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
