<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $fillable = ['name', 'slug', 'parent_id', 'status', 'home_page', 'image',
        'meta', 'description'];

    private array $report_fields = [
        'id', 'name', 'slug', 'meta', 'status', 'parent_id', 'image', 'home_page', 'deleted_at',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'blog_category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function select_categories()
    {
        return $this->where('status', 1)
            ->get(['id', 'name', 'parent_id']);
    }

    public function all_categories()
    {
        return BlogCategory::get(['id', 'name', 'parent_id']);
    }

    public function all_items(string $search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->with(['parent:id,name,slug,parent_id'])
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function sidebar_categories()
    {
        return $this->where('status', true)
            ->withCount('posts')
            ->get(['id', 'name', 'slug', 'image']);
    }
}
