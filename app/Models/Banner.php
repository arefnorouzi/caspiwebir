<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $guarded = [];

    public function page_section(): BelongsTo
    {
        return $this->belongsTo(PageSection::class);
    }

    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%' . $search_text . '%');
            })
            ->with(['page_section:id,name'])
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
    }
}
