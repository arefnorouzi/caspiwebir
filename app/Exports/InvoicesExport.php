<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Invoice::query()
            ->where('created_at', '>=', now()->subDays(10))
            ->orderby('id','desc')
            ->with(['status', 'payment_method:id,name', 'shipping_method:id,name'])
            ->select('id', 'payment_status', 'invoice_status_id', 'customer_name', 'customer_mobile', 'customer_state', 'customer_zip_code', 'customer_city', 'customer_address', 'created_at', 'purchased_at',
                'tax', 'amount', 'sub_total', 'discount', 'shipping_cost', 'shipping_method_id', 'payment_method_id'
            );
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->customer_name,
            $invoice->customer_mobile,
            $invoice->payment_status ? 'پرداخت شده' : 'پرداخت نشده',
            $invoice->status->name,
            $invoice->sub_total,
            $invoice->shipping_cost,
            $invoice->tax,
            $invoice->discount,
            $invoice->amount,
            verta($invoice->created_at)->format('Y-m-d'),
            $invoice->purchased_at ? verta($invoice->purchased_at)->format('Y-m-d') : null,
            $invoice?->payment_method?->name ?? '',
            $invoice?->shipping_method?->name ?? '',
            $invoice->customer_zip_code,
            $invoice->customer_city,
            $invoice->customer_address,
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Mobile', 'Purchased', 'Status', 'SubTotal', 'ShippingCost', 'Tax', 'Discount', 'Amount', 'CreatedAt', 'PurchasedAt', 'ZipCode', 'State', 'City', 'Address'];
    }
}
