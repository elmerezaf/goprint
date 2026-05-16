<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'description',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isValid($orderAmount)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return false;
        }

        if ($this->valid_from && now()->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && now()->gt($this->valid_until)) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderAmount)
    {
        if (!$this->isValid($orderAmount)) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = $orderAmount * ($this->value / 100);
        } else {
            $discount = $this->value;
        }

        return min($discount, $orderAmount);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}