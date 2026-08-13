<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $guarded = [];
    private array $report_fields = [
        'id', 'name', 'slug', 'meta', 'status', 'parent_id', 'image', 'home_page', 'deleted_at'
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'category_products',
            'category_id',
            'product_id'
        )->withTimestamps();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
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

    public function select_categories()
    {
        return $this->where('parent_id', null)
            ->with('children:id,name,parent_id')
            ->get(['id', 'name', 'parent_id']);
    }

    public function all_categories($id = null)
    {
        return Category::get(['id', 'name', 'parent_id']);
    }

}
