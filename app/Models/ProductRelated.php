<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRelated extends Model
{
    protected $table = 'product_related';
    protected $guarded = [];

    public function product_related(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'related_product_id');
    }
}
