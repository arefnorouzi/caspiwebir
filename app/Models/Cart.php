<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'session_id', 'status', 'sub_total',
        'discount', 'coupon_code', 'coupon_id', 'total_amount',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function get_shopping_cart()
    {
        return Cart::query()
            ->with(['items', 'items.product', 'items.variant'])
            ->where('status', true)
            ->when(auth()->check(), fn ($q) => $q->where('user_id', auth()->id()))
            ->when(! auth()->check(), fn ($q) => $q->where('session_id', session()->getId()))
            ->first();
    }

    public function all_items(string $search_text = '', int $per_page = 20)
    {
        return $this
            ->where('status', 1)
            ->when($search_text, function ($query, $search_text) {
                $query->where('id', '=', intval($search_text))
                    ->orWhere('user_id', '=', '%'.$search_text.'%')
                    ->orWhere('coupon_code', '=', '%'.$search_text.'%');
            })
            ->orderBy('id', 'desc')
            ->with(['items', 'user:id,name'])
            ->paginate($per_page)->withQueryString();
    }

}
