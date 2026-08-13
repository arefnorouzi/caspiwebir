<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingMethod extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingMethodFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $guarded = [];
}
