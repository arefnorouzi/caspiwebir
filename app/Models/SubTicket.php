<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTicket extends Model
{
    /** @use HasFactory<\Database\Factories\SubTicketFactory> */
    use HasFactory;
    protected $guarded = [];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
