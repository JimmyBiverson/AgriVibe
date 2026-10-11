<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FarmEnterprise extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'farm_id', 'enterprise_type_id', 'name', 'description',
        'quantity', 'unit', 'size', 'status', 'started_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'size' => 'decimal:2',
            'started_at' => 'date',
        ];
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function enterpriseType(): BelongsTo
    {
        return $this->belongsTo(EnterpriseType::class);
    }
}
