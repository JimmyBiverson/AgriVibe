<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnterpriseType extends Model
{
    protected $fillable = ['name', 'slug', 'sector', 'icon', 'description', 'is_active', 'sort'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function farmEnterprises(): HasMany
    {
        return $this->hasMany(FarmEnterprise::class);
    }

    public function species(): HasMany
    {
        return $this->hasMany(Species::class);
    }
}
