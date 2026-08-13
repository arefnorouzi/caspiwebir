<?php

namespace App\Models;

use App\Concerns\HasPin;
use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory, HasPin, HasStatus, SoftDeletes;

    protected $guarded = [];

    private array $report_fields = [
        'id', 'name', 'slug', 'status', 'home_page', 'website', 'image', 'deleted_at',
    ];

    public function products(): HasMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function select_brands()
    {
        return $this->get(['id', 'name']);
    }

    public function all_items($search_text = '', int $perPage = 20): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function home_page_brands()
    {
        return $this->where('status', 1)->where('image', '!=', null)->get(['id', 'name', 'image']);
    }
}
