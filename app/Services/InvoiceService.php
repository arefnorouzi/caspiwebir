<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\ShippingMethod;
use App\Models\ShopSetting;

class InvoiceService
{
    public static function refresh_invoice($id)
    {
        $invoice = Invoice::where('id', $id)->where('payment_status', false)->first();
        if ($invoice) {
            $invoice->load(['items']);
            if (count($invoice->items) == 0) {
                return null;
            }
            $shop_setting = ShopSetting::first();
            $sub_total = 0;
            $shipping_cost = 0;
            if ($invoice->shipping_method_id) {
                $shipping_method = ShippingMethod::where('id', $invoice->shipping_method_id)->first();
                if ($shipping_method) {
                    $shipping_cost = $shipping_method->base_cost + $shipping_method->box_cost;
                }
            }
            $discount = 0;
            $tax = 0;
            foreach ($invoice->items as $item) {
                $sub_total += $item->item_price * $item->qty;
                $shipping_cost += max(0, $item->shipping_cost * $item->qty);
                $item->discount = max(0, $item->item_price - $item->unit_price);
                $item->update();
                $discount += $item->discount * $item->qty;
            }
            $total = max(0, intval($sub_total + $shipping_cost - $discount));
            if ($shop_setting->tax) {
                $tax = intval($total * $shop_setting->tax / 100);
            }
            $total += $tax;
            $invoice->amount = $total;
            $invoice->sub_total = $sub_total;
            $invoice->shipping_cost = $shipping_cost;
            $invoice->discount = $discount;
            $invoice->tax = $tax;
            $invoice->update();

            return $invoice;
        }

        return null;
    }
}
