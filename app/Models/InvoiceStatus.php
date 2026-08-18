<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceStatus extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceStatusFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function get_status(string $code)
    {
        $status = InvoiceStatus::where('code', $code)->first();
        if ($status) {
            return $status->id;
        }

        return null;
    }

    public function all_items($search_text = '', int $perPage = 20): object
    {
        return $this->withTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%');
            })
            ->orderBy('id', 'asc')
            ->paginate($perPage)->withQueryString();
    }

}
