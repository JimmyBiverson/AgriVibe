<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesPublicId
{
    protected static function bootGeneratesPublicId(): void
    {
        static::creating(function ($model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
