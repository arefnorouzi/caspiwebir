<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    /** @use HasFactory<\Database\Factories\ProductUnitFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    private array $report_fields = [
        'id', 'name', 'is_default', 'status', 'deleted_at'
    ];

    public function select_units()
    {
        return $this->where('status', true)
            ->orderBy('is_default', 'desc')
            ->get(['id', 'name', 'is_default']);
    }

    public function all_items($search_text = '', int $perPage = 30): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%' . $search_text . '%');
            })
            ->orderBy('status', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }
}
