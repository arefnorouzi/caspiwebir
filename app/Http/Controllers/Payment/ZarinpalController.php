<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLog;
use App\Models\InvoiceStatus;
use App\Models\PaymentMethod;
use App\Models\ShopSetting;
use App\Services\Gateway\Zarinpal;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZarinpalController extends Controller
{
    public function pay($id)
    {
        $invoice_model = new Invoice();
        $invoice = $invoice_model->find_for_pay($id);
        if (!$invoice)
        {
            return redirect('/checkout')->with("error", "فاکتور برای پرداخت پیدا نشد");
        }
        $payment_method = PaymentMethod::where('code', 'zarinpal')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
        }

        $url = 'https://payment.zarinpal.com/pg/v4/payment/request.json';

//        $merchant = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
//        $url = 'https://sandbox.zarinpal.com/pg/v4/payment/request.json';

        $payload =json_encode(array(
            'merchant_id' => $payment_method->merchant,
            'amount' => intval($invoice->amount * 10),
            'callback_url' => route('payment.zarinpal.callback'),
            'description' => "شماره سفارش: $invoice->id",
            'metadata' => array(
                'order_id' => "$invoice->id",
                'mobile' => $invoice->user->mobile,
            )
        ));

        try {
            $zarinpal_service = new Zarinpal();
            $request = $zarinpal_service->send_request($url, $payload);
            $response = json_decode($request, true);
            if (isset($response['data']) && $response['data']['code'] == 100) {
                $token = $response['data']['authority'];
                $invoice->bank_invoice_token = $token;
                $invoice->update();
                return redirect("https://payment.zarinpal.com/pg/StartPay/" . $token);
                //return redirect("https://sandbox.zarinpal.com/pg/StartPay/" . $token);
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
        if (count($_GET) != 2)
        {
            return redirect()->route('payment.fail');
        }
        if (isset($request->Authority) && isset($request->Status))
        {
            if ($request->Status == 'OK')
            {
                $invoice_model = new Invoice();
                $invoice = $invoice_model->find_for_verify(bank_token: $request->Authority);
                if (!$invoice)
                {
                    return redirect()->route('payment.fail');
                }
                $payment_method = PaymentMethod::where('code', 'zarinpal')
                    ->where('status', true)->first();
                if (!$payment_method)
                {
                    return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
                }
                $url = "https://payment.zarinpal.com/pg/v4/payment/verify.json";

//                $url = "https://sandbox.zarinpal.com/pg/v4/payment/verify.json";
//                $merchant = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";

                $payload =json_encode(array(
                    'merchant_id' => $payment_method->merchant,
                    'authority' => $invoice->bank_invoice_token,
                    'amount' => intval($invoice->amount * 10),
                    'description' => "شماره سفارش: $invoice->id"
                ));
                try {
                    $zarinpal_service = new Zarinpal();
                    $req = $zarinpal_service->send_request($url, $payload);
                    $response = json_decode($req, true);
                    if (isset($response['data']) && $response['data']['code'] == 100) {
                        $invoice->payment_status = true;
                        $invoice->invoice_status_id = InvoiceStatus::get_status(code: 'paid');
                        $invoice->bank_trans_id = $response['data']["ref_id"];
                        $invoice->purchased_at = now();
                        $invoice->update();
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
        }
        return redirect()->route('payment.fail');
    }
}
