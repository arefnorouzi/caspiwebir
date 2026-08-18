<?php

namespace App\Models;

use App\Concerns\HasPin;
use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasPin, HasStatus, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['active_price']; // optional: include in JSON/array output

    private array $report_fields = [
        'id', 'name', 'slug', 'status', 'pinned', 'image', 'user_id', 'stock', 'price', 'offer_price', 'sales',
        'published_at', 'created_at', 'updated_at', 'deleted_at', 'offer_end_date', 'brand_id', 'suggested',
        'amazing', 'min_buy', 'pre_order', 'buyable', 'installment_purchase', 'course_time', 'duration', 'meta'
    ];

    private array $product_cart_fields = [
        'id', 'name', 'slug', 'suggested', 'pinned', 'image', 'stock', 'price', 'offer_price',
        'published_at', 'offer_end_date', 'brand_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
            'published_at' => 'datetime:Y-m-d',
            'offer_end_date' => 'datetime:Y-m-d',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function role_prices(): HasMany
    {
        return $this->hasMany(ProductRolePrice::class, 'product_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class)->with('lessons');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function find_instock_product($product_id)
    {
        return $this->active()->where('id', $product_id)->where('stock', '>', 0)->first();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_product',
            'product_id',
            'category_id'
        )->withTimestamps();
    }
    public function properties(): HasMany
    {
        return $this->hasMany(ProductProperty::class, 'product_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function confirmed_comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', true);
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(\App\Models\Vote::class, 'votable');
    }

    public function averageRating()
    {
        return $this->votes()->avg('value');
    }

    public function getActivePriceAttribute()
    {
        $now = now(); // Laravel helper, uses app timezone

        if ($this->offer_price !== null) {
            if (!$this->offer_end_date)
            {
                return $this->offer_price;
            }
            elseif ($this->offer_end_date && $now->lessThan($this->offer_end_date))
            {
                return $this->offer_price;
            }
        }
        return $this->price;
    }

    #[Scope]
    protected function scopeActive(Builder $query): void
    {
        $query->where([['status', '=', true], ['image', '!=', null]])
            ->where('price', '>', 0)
            ->where('published_at', '!=', null);
    }
    #[Scope]
    protected function scopeRegular(Builder $query): void
    {
        $query->where('downloadable',  0)
        ->where('is_service', 0)
        ->where('is_addon', 0);
    }

    #[Scope]
    protected function scopeService(Builder $query): void
    {
        $query->where('is_service',  1);
    }

    #[Scope]
    protected function scopeAddon(Builder $query): void
    {
        $query->where('is_addon',  1);
    }

    #[Scope]
    protected function scopeDownloadable(Builder $query): void
    {
        $query->where('downloadable',  1);
    }

    #[Scope]
    protected function scopeInstock(Builder $query): void
    {
        $query->where('stock', '>', 0);
    }

    #[Scope]
    protected function scopeSuggested(Builder $query): void
    {
        $query->where('suggested', '=', true);
    }

    #[Scope]
    protected function scopeFeatured(Builder $query): void
    {
        $query->where('pinned', true);
    }

    #[Scope]
    protected function scopeLimitted(Builder $query): void
    {
        $query->whereNotNull('offer_end_date')
            ->whereNotNull('offer_price')->where('offer_end_date', '>', now()->format('Y-m-d'));
    }

    #[Scope]
    protected function scopeAmazing(Builder $query): void
    {
        $query->where('amazing', true)->whereNotNull('offer_price');
    }

    public function find_for_add_to_cart(int $id)
    {
        return $this->active()->instock()->where('id', $id)->first();
    }

    #[Scope]
    protected function scopeOffer(Builder $query): void
    {
        $query->whereNotNull('offer_price')
            ->where('offer_price', '>', 0);
    }

    public function home_page_products(int $per_page = 12)
    {
        return $this->active()->orderBy('published_at', 'desc')
            ->where('home_page', 1)
            ->paginate($per_page, $this->report_fields);
    }

    public function search_products(string $q, int $per_page = 12)
    {
        return $this->active()->instock()
            ->where(function($query) use ($q){
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('model', 'like', "%{$q}%")
                    ->orWhereHas('brand', function($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })->orderBy('views', 'desc')
            ->paginate($per_page, $this->report_fields);
    }

    public function suggested_products(int $per_page = 12)
    {
        return $this->active()->instock()->suggested()->orderBy('updated_at', 'desc')
            ->paginate($per_page, $this->report_fields);
    }

    public function amazing_products(int $per_page = 12)
    {
        return $this->active()->instock()->amazing()->orderBy('updated_at', 'desc')
            ->paginate($per_page, $this->report_fields);
    }

    public function popular_products(int $per_page = 8)
    {
        return $this->active()->instock()->orderBy('views', 'desc')
            ->orderby('rank', 'asc')
            ->paginate($per_page, $this->report_fields);
    }

    public function downloadable_products(int $per_page = 12)
    {
        return $this->active()->instock()->downloadable()->orderBy('rank', 'asc')
            ->paginate($per_page, $this->report_fields);
    }

    public function service_products(int $per_page = 12)
    {
        return $this->active()->instock()->service()->orderBy('rank', 'asc')
            ->paginate($per_page, $this->report_fields);
    }

    public function addons_products(int $per_page = 12)
    {
        return $this->active()->instock()->addon()->orderBy('rank', 'asc')
            ->paginate($per_page, $this->report_fields);
    }
    public function best_sellers_products(int $per_page = 12)
    {
        return $this->active()->instock()->orderBy('sales', 'desc')
            ->take($per_page)
            ->get($this->report_fields);
    }

    public function recent_products($search_text = '', int $per_page = 20)
    {
        return $this->active()
            ->orderby('rank', 'asc')
            ->orderBy('brand_id', 'asc')
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhere('model', 'like', '%'.$search_text.'%');
            })
            ->with(['brand'])
            ->paginate($per_page, $this->report_fields)
            ->withQueryString();
    }

    public function category_products(array $ids, $search_text = '', int $per_page = 20)
    {
        return $this->active()
            ->whereHas('categories', function ($q) use ($ids) {
                $q->whereIn('categories.id', $ids);
            })
            ->orderby('rank', 'asc')
            ->orderBy('views', 'desc')
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhere('sku', 'like', '%'.$search_text.'%');
            })
            ->paginate($per_page, $this->report_fields)
            ->withQueryString();
    }

    public function brand_products(int $brand_id, $search_text = '', int $per_page = 20)
    {
        return $this->active()
            ->where('brand_id', $brand_id)
            ->orderby('rank', 'asc')
            ->orderBy('views', 'desc')
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhere('sku', 'like', '%'.$search_text.'%');
            })
            ->paginate($per_page, $this->report_fields)
            ->withQueryString();
    }

    public function limitted_offer_products(int $perPage = 12): object
    {
        return $this->active()->instock()->limitted()->orderBy('updated_at', 'desc')
            ->paginate($perPage, $this->report_fields);
    }

    public function offer_products(int $perPage = 8): object
    {
        return $this->active()->instock()->offer()
            ->orderby('rank', 'asc')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, $this->report_fields);
    }

    public function featured_products(int $perPage = 8): object
    {
        return $this->active()->instock()->featured()
            ->orderby('rank', 'asc')
            ->orderBy('views', 'desc')
            ->paginate($perPage, $this->report_fields);
    }

    public function all_items($request, int $perPage = 20): object
    {
        return Product::query()
            ->when($request->search, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                ->orWhere('model', 'like', '%'.$search_text.'%')
                ->orWhere('sku', 'like', '%'.$search_text.'%')
                    ->orWhereHas('brand', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->when($request->category, function ($query, $category_id) {
                $query->whereHas('categories', function ($q) use ($category_id) {
                        $q->where('category_id', '=', $category_id);
                    });
            })
            ->when($request->brand, fn ($q) => $q->where('brand_id', $request->brand))
            ->when($request->status, fn ($q) => $q->where('status', true))
            ->when($request->suggested, fn ($q) => $q->where('suggested', true))
            ->when($request->pinned, fn ($q) => $q->where('pinned', true))
            ->when($request->amazing, fn ($q) => $q->where('amazing', true))
            ->when($request->installment, fn ($q) => $q->where('installment_purchase', true))
            ->when($request->buyable, fn ($q) => $q->where('buyable', true))
            ->when($request->pre_order, fn ($q) => $q->where('pre_order', true))
            ->with(['brand:id,name'])
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function outofstock_items($search_text = '', int $perPage = 10): object
    {
        return $this->where('stock', 0)
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhereHas('brand', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->with(['brand:id,name'])
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function trash_items($search_text = '', int $perPage = 10): object
    {
        return $this->onlyTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhereHas('brand', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->with(['brand:id,name'])
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function related_products($product_id, $categories = [], $brand_id = null, $limit = 8)
    {
        return $this->active()
            ->where('id', '!=', $product_id) // محصول فعلی حذف بشه
            ->where(function ($q) use ($categories, $brand_id) {
                // محصولات با برند مشترک
                if ($brand_id) {
                    $q->where('brand_id', $brand_id);
                }
                // یا محصولات با دسته‌بندی مشترک
                $q->orWhereHas('categories', function ($subQuery) use ($categories) {
                    $subQuery->whereIn('categories.id', $categories);
                });
            })
            ->with(['categories:id,name,slug', 'brand:id,name,slug'])
            ->orderBy('rank', 'desc')
            ->take($limit)->get($this->report_fields);
    }

    public function related_items($ids, $limit = 8)
    {
        return $this->active()
            ->whereIn('id', $ids)
            ->with(['categories:id,name,slug', 'brand:id,name,slug', 'variants'])
            ->orderBy('rank', 'desc')
            ->take($limit)->get($this->report_fields);
    }

    public function show_product_by_slug($slug)
    {
        return $this->active()
            ->where('slug', $slug)->firstOrFail();
    }

    public function user_items(int $user_id, int $perPage = 10, $search_text = ''): object
    {
        return $this->withTrashed()
            ->where('user_id', $user_id)
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhereHas('brand', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->with(['brand:id,name', 'author:id,name,'])
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields);
    }
}
