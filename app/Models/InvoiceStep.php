<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceStep extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceStepFactory> */
    use HasFactory;
    protected $guarded = [];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function invoice_status(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class);
    }
}
