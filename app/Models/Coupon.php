<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $fillable = [
        'code', 'coupon_type', 'value', 'min_purchase', 'max_usage',
        'used_count', 'starts_at', 'expires_at', 'active',
    ];

    protected $casts = [
        'starts_at' => 'datetime:Y-m-d H:i:s',
        'expires_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function isValidFor($cart)
    {
        if (! $this->active) {
            return false;
        }
        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }
        if ($this->max_usage && $this->used_count >= $this->max_usage) {
            return false;
        }
        if ($this->min_purchase && $cart->sub_total < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($cart)
    {
        if ($this->coupon_type === 'percent') {
            $items_discount = 0;
            foreach ($cart->items as $item) {
                $items_discount += max(0, $item->item_price - $item->unit_price);
            }
            $discount = intval(max(0, $cart->sub_total - $items_discount) * ($this->value / 100));
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } else {
            $discount = $this->value;
        }

        return min($discount, $cart->sub_total);
    }

    public function applyDiscount($amount)
    {
        if ($this->type === 'percent') {
            return $amount - ($amount * ($this->value / 100));
        }

        return max($amount - $this->value, 0);
    }

    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
    }
}
