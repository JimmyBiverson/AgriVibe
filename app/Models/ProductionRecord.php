<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionRecord extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'record_date' => 'date',
        'quantity' => 'decimal:2',
        'retained_home_use' => 'decimal:2',
        'sold_quantity' => 'decimal:2',
        'unit_selling_price' => 'decimal:2',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(AnimalBatch::class, 'animal_batch_id');
    }
}
