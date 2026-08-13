<?php

namespace App\Models;

use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory, HasStatus, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
        ];
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function support(): BelongsTo
    {
        return $this->belongsTo(User::class, 'support_id');
    }

    public function all_items($search_text = '', int $perPage = 20): object
    {
        return $this->withTrashed()->orderBy('id', 'desc')
            ->with(['user:id,name', 'commentable:id,name,slug'])->paginate($perPage);
    }
}
