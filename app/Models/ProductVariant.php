<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['active_price']; // optional: include in JSON/array output
    protected $casts = [
        'offer_end_date' => 'datetime', // Ensures Carbon instance
    ];
    /**
     * Get the product that owns the product variant.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    #[Scope]
    protected function scopeActive(Builder $query): void
    {
        $query->where('status',  true);
    }
    #[Scope]
    protected function scopeInstock(Builder $query): void
    {
        $query->where('stock', '>',  0);
    }
    public function getActivePriceAttribute()
    {
        $now = now(); // Laravel helper, uses app timezone

        if ($this->offer_price !== null) {
            if (!$this->offer_end_date)
            {
                return $this->offer_price;
            }
            elseif ($this->offer_end_date && $now->lessThan($this->offer_end_date))
            {
                return $this->offer_price;
            }
        }
        return $this->price;
    }


    public function find_for_add_to_cart(int $id)
    {
        return $this->active()->instock()->where('id', $id)->first();
    }

}
