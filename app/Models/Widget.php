<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    /** @use HasFactory<\Database\Factories\WidgetFactory> */
    use HasFactory, HasStatus, SoftDeletes;
    protected $guarded = [];
    private array $report_fields = [
        'id', 'name', 'deleted_at',
    ];


    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }
}
