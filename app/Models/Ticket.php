<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function sub_tickets(): HasMany
    {
        return $this->hasMany(SubTicket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function dashboard_tickets(int $uid, int $limit = 4)
    {
        return $this->where('user_id', $uid)->orderby('id', 'desc')->take($limit)
            ->with(['status'])
            ->get([
                'id', 'title', 'status_id', 'updated_at',
            ]);
    }

    public function all_items(string $search_text = '', int $status_id = null, int $per_page = 20)
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('id', '=', intval($search_text))
                    ->orWhere('title', 'like', '%' . $search_text . '%');
            })
            ->when($status_id, function ($query, $status_id) {
                $query->where('status_id', '=', intval($status_id));
            })
            ->orderBy('status_id', 'asc')
            ->orderBy('id', 'desc')
            ->with(['user:id,name', 'status:id,name,css_class'])
            ->paginate($per_page)->withQueryString();
    }
}
