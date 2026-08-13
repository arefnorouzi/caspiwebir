<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    /** @use HasFactory<\Database\Factories\VoteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'votable_id', 'votable_type', 'value',
    ];

    public function votable(): MorphTo
    {
        return $this->morphTo();
    }
}
