<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $guarded = [];
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
            'published_at' => 'datetime:Y-m-d',
        ];
    }
    private array $report_fields = [
        'id', 'name', 'slug', 'status', 'pinned', 'image', 'user_id',
        'published_at', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhereHas('category', function ($q) use ($search_text) {
                        $q->where('name', 'like', "%{$search_text}%");
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }
}
