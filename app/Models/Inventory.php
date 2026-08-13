<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%' . $search_text . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['id', 'name', 'phone', 'address', 'status', 'deleted_at'])
            ->withQueryString();
    }
}
