<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShopSetting;
use App\Services\Gateway\DigiPay;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DigiPayController extends Controller
{
    public function pay($id)
    {
        $invoice_model = new Invoice();
        $invoice = $invoice_model->find_for_pay($id);
        if (!$invoice)
        {
            return redirect('/chrckout')->with("error", "فاکتور برای پرداخت پیدا نشد");
        }
        $payment_method = PaymentMethod::where('code', 'digipay')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
        }

        try {
            $digipay_service = new DigiPay();
            $response = $digipay_service->credit(invoice: $invoice, type: 0, preferredGateway: 2);
            if ($response['result']['status'] == 0) {

                $invoice->bank_invoice_token = $response['ticket'];
                $invoice->update();
                return redirect($response['redirectUrl']);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return redirect('/checkout')
            ->with("error", "خطا در ارتباط با درگاه بانکی. لطفا درگاه بانکی دیگری را انتخاب نمایید");
    }

    public function verify(Request $request)
    {
        Log::info($request->all());
        //dd($request->all());
        if (
            !$request->filled('amount') ||
            !$request->filled('providerId') ||
            !$request->filled('trackingCode') ||
            !$request->filled('result') ||
            !$request->filled('type')
        )
        {
            return redirect()->route('payment.fail');
        }
        if (isset($request->result) && $request->result == 'SUCCESS')
        {
            $token = intval($request->providerId);
            $invoice_model = new Invoice();
            $invoice = $invoice_model->find_for_pay(id: $token);
            if (!$invoice)
            {
                return redirect()->route('payment.fail');
            }
            $payment_method = PaymentMethod::where('code', 'digipay')
                ->where('status', true)->first();
            if (!$payment_method)
            {
                return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
            }
            try {
                $digipay_service = new DigiPay();
                $response = $digipay_service->verify($invoice, $request->trackingCode);
                if($response['result']['status'] == 0) {
                    $invoice->payment_status = true;
                    $invoice->invoice_status_id = InvoiceStatus::get_status(code: 'paid');
                    $invoice->bank_payment_code = $response['trackingCode'];
                    $invoice->purchased_at = now();
                    $invoice->update();
                    $invoice->load('items');
                    foreach ($invoice->items as $item)
                    {
                        if ($item->product_id && isset($item->product))
                        {
                            $product = Product::where('id', '=', $item->product_id)->first();
                            if ($product){
                                $product->sales += $item->qty;
                                if (!$product->downloadable)
                                {
                                    $product->stock = max(0, $product->stock - $item->qty);
                                }
                                $product->update();
                            }

                        }
                    }
                    // send sms
                    SmsService::invoice_sms(
                        to: $invoice->customer_mobile,
                        invoice_number: $invoice->id,
                        status: "پرداخت شده"
                    );
                    $shop_setting = ShopSetting::first();
                    if ($shop_setting)
                    {
                        SmsService::invoice_sms(
                            to: $shop_setting->mobile,
                            invoice_number: $invoice->id,
                            status: "پرداخت شده"
                        );
                    }
                    return redirect()->route('payment.success');
                }
                else{
                    $invoice->failed_attempts =  $invoice->failed_attempts + 1;
                    $invoice->update();

                    return redirect()->route('payment.fail');
                }
            }
            catch (\Exception $e)
            {
                Log::error($e->getMessage());
            }
            return redirect()->route('payment.fail');
        }
        return redirect()->route('payment.fail');
    }
}
