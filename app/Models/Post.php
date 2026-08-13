<?php

namespace App\Models;

use App\Concerns\HasPin;
use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, HasPin, HasStatus, SoftDeletes;

    protected $guarded = [];

    private array $report_fields = [
        'id', 'name', 'slug', 'status', 'pinned', 'image', 'user_id',
        'published_at', 'created_at', 'updated_at', 'deleted_at', 'blog_category_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
            'published_at' => 'datetime:Y-m-d',
        ];
    }

    public function votes()
    {
        return $this->morphMany(\App\Models\Vote::class, 'votable');
    }

    public function averageRating()
    {
        return $this->votes()->avg('value');
    }

    #[Scope]
    protected function scopeActive(Builder $query): void
    {
        $query->where('status', 1)
            ->where('published_at', '!=', null);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function home_page_posts(int $count = 6)
    {
        return $this->active()->orderBy('published_at', 'desc')
            ->with(['category:id,name,slug', 'author:id,name'])
            ->take($count)->get($this->report_fields);
    }

    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhereHas('category', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->with(['category:id,name,slug', 'author:id,name'])
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function user_items(int $uid, $search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->where('user_id', $uid)
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhereHas('category', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->with(['category:id,name,slug', 'author:id,name'])
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function related_posts(int $blog_category_id, $count = 6)
    {
        return $this::where('blog_category_id', $blog_category_id)
            ->where('status', true)->take($count)->get($this->report_fields);
    }
}
