<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function all_items($search_text = '', int $perPage = 20): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
    }

    public function media_list(string $media_type = 'image', int $perPage = 20): object
    {
        return $this->withTrashed()
            ->where('media_type', $media_type)
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
    }
}
