<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory, SoftDeletes;

    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'created_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipping_method(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(InvoiceLog::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    public function invoice_type(): BelongsTo
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }

    public function all_items(string $search_text = '', ?int $status_id = null, ?int $type_id = null, int $per_page = 20)
    {
        return $this
            ->when($search_text, function ($query, $search_text) {
                $query->where('id', '=', intval($search_text))
                    ->orWhere('uuid', 'like', '%'.$search_text.'%');
            })
            ->when($status_id, function ($query, $status_id) {
                $query->where('invoice_status_id', '=', intval($status_id));
            })
            ->when($type_id, function ($query, $type_id) {
                $query->where('invoice_type_id', '=', intval($type_id));
            })
            ->orderBy('id', 'desc')
            ->with(['items', 'user:id,name', 'status:id,name,css_class', 'invoice_type:id,name,css_class'])
            ->paginate($per_page)->withQueryString();
    }

    public function purchased_items(string $search_text = '', ?int $status_id = null, ?int $type_id = null, int $per_page = 20)
    {
        return $this->where('payment_status', true)
            ->when($search_text, function ($query, $search_text) {
                $query->where('id', '=', intval($search_text))
                    ->orWhere('uuid', 'like', '%'.$search_text.'%');
            })
            ->when($status_id, function ($query, $status_id) {
                $query->where('invoice_status_id', '=', intval($status_id));
            })
            ->when($type_id, function ($query, $type_id) {
                $query->where('invoice_type_id', '=', intval($type_id));
            })
            ->orderBy('purchased_at', 'desc')
            ->with(['user:id,name', 'status:id,name,css_class', 'invoice_type:id,name,css_class'])
            ->paginate($per_page)->withQueryString();
    }

    public function trash_items(string $search_text = '', ?int $status_id = null, ?int $type_id = null, int $per_page = 10)
    {
        return $this->onlyTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('id', '=', intval($search_text))
                    ->orWhere('uuid', 'like', '%'.$search_text.'%');
            })
            ->when($status_id, function ($query, $status_id) {
                $query->where('invoice_status_id', '=', intval($status_id));
            })
            ->when($type_id, function ($query, $type_id) {
                $query->where('invoice_type_id', '=', intval($type_id));
            })
            ->orderBy('id', 'desc')
            ->with(['items', 'user:id,name', 'status:id,name,css_class', 'invoice_type:id,name,css_class'])
            ->paginate($per_page)->withQueryString();
    }

    public function user_items(int $uid, string $search_text = '', ?int $status_id = null, ?int $type_id = null, int $per_page = 10)
    {
        return $this->where('user_id', $uid)
            ->when($search_text, function ($query, $search_text) {
                $query->where('id', '=', intval($search_text))
                    ->orWhere('uuid', 'like', '%'.$search_text.'%');
            })
            ->when($status_id, function ($query, $status_id) {
                $query->where('invoice_status_id', '=', intval($status_id));
            })
            ->when($type_id, function ($query, $type_id) {
                $query->where('invoice_type_id', '=', intval($type_id));
            })
            ->orderBy('id', 'desc')
            ->with(['items', 'status', 'invoice_type'])
            ->paginate($per_page)->withQueryString();
    }

    public function find_for_pay($id)
    {
        return $this->where('id', $id)
            ->where('payment_status', 0)->first();
    }

    public function find_for_verify($bank_token)
    {
        return $this->where('bank_invoice_token', $bank_token)
            ->where('payment_status', 0)->first();
    }
}
