<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialNetwork extends Model
{
    /** @use HasFactory<\Database\Factories\SocialNetworkFactory> */
    use HasFactory;

    protected $guarded = [];

    public function all_items($search_text = '', int $perPage = 20): object
    {
        return $this->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
    }
}
