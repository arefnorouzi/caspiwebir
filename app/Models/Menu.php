<?php

namespace App\Models;

use App\Concerns\HasPin;
use App\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory, HasPin, HasStatus, SoftDeletes;
    protected $guarded = [];

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function all_items()
    {
        return $this->query()
            ->withTrashed()
            ->whereNull('parent_id')
            ->with(['childrenRecursive'])
            ->orderBy('rank')
            ->get()->groupBy('position');
    }
}
