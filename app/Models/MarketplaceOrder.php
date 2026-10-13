<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MarketplaceOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'dispatched_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $order): void {
            $order->order_number ??= 'AGV-'.now()->format('ymd').'-'.strtoupper(Str::random(5));
        });
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(MarketplaceItem::class, 'marketplace_item_id');
    }

    public function getBalanceAttribute(): float
    {
        return max(0, (float) $this->total_amount - (float) $this->amount_paid);
    }

    public function isOpen(): bool
    {
        return ! in_array($this->status, ['completed', 'cancelled', 'disputed'], true);
    }
}
