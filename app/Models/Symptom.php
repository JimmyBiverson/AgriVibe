<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Symptom extends Model
{
    protected $fillable = ['name', 'slug'];

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class);
    }
}
