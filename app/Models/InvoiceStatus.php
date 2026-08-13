<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceStatusFactory> */
    use HasFactory;

    protected $guarded = [];

    public static function get_status(string $code)
    {
        $status = InvoiceStatus::where('code', $code)->first();
        if ($status) {
            return $status->id;
        }

        return null;
    }
}
