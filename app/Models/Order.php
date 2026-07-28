<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_id',
        'tracking_number',
        'package_description',
        'package_size',
        'is_fragile',
        'pickup_address',
        'pickup_contact',
        'pickup_phone',
        'delivery_address',
        'delivery_contact',
        'delivery_phone',
        'amount',
        'status',
        'payment_status',
        'payment_ref',
        'pickup_lat',
        'pickup_lng',
        'delivery_lat',
        'delivery_lng',
        'current_lat',
        'current_lng',
        'estimated_arrival',
    ];

    protected $casts = [
        'is_fragile' => 'boolean',
        'amount' => 'decimal:2',
        'pickup_lat' => 'decimal:7',
        'pickup_lng' => 'decimal:7',
        'delivery_lat' => 'decimal:7',
        'delivery_lng' => 'decimal:7',
        'current_lat' => 'decimal:7',
        'current_lng' => 'decimal:7',
        'estimated_arrival' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_TRANSIT = 'transit';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the customer who placed this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the delivery agent assigned to this order.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get all location tracking records for this order.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(OrderLocation::class);
    }

    /**
     * Get the latest location for this order.
     */
    public function latestLocation()
    {
        return $this->hasOne(OrderLocation::class)->latestOfMany('recorded_at');
    }

    /**
     * Check if order is currently in transit.
     */
    public function isInTransit(): bool
    {
        return $this->status === self::STATUS_TRANSIT;
    }

    /**
     * Get status badge color.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'badge-light-info',
            self::STATUS_TRANSIT => 'badge-light-warning',
            self::STATUS_DELIVERED => 'badge-light-success',
            self::STATUS_CANCELLED => 'badge-light-danger',
            default => 'badge-light-secondary',
        };
    }
}
