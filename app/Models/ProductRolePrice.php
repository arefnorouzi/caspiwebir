<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRolePrice extends Model
{
    /** @use HasFactory<\Database\Factories\ProductRolePriceFactory> */
    use HasFactory;

    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }
}
