<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductProperty extends Model
{
    /** @use HasFactory<\Database\Factories\ProductPropertyFactory> */
    use HasFactory;
    protected $guarded = [];
    private array $report_fields = [
        'id', 'property_name', 'property_value', 'property_status', 'status', 'pinned', 'image', 'deleted_at',
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->when($search_text, function ($query, $search_text) {
            $query->where('name', 'like', '%'.$search_text.'%');
        })->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }
}
