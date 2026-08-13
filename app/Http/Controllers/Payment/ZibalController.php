<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLog;
use App\Models\InvoiceStatus;
use App\Models\PaymentMethod;
use App\Models\ShopSetting;
use App\Services\Gateway\Zibal;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZibalController extends Controller
{
    public function pay($id)
    {
        $invoice_model = new Invoice();
        $invoice = $invoice_model->find_for_pay($id);
        if (!$invoice)
        {
            return redirect('/chrckout')->with("error", "فاکتور برای پرداخت پیدا نشد");
        }
        $payment_method = PaymentMethod::where('code', 'zibal')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
        }
        $payload =json_encode(array(
            "merchant"=> $payment_method->merchant,//required
            "callbackUrl"=> route('payment.zibal.callback'),//required
            'amount' => intval($invoice->amount * 10),
            "orderId"=> $invoice->id, //optional
            "mobile"=> $invoice->customer_mobile,//optional for mpg
        ));

        try {
            $zibal_service = new Zibal();
            $req = $zibal_service->send_request('request', $payload);
            $response = json_decode($req);
            if ($response->result == 100) {
                $token = $response->trackId;
                $invoice->bank_invoice_token = $token;
                $invoice->update();
                return redirect("https://gateway.zibal.ir/start/" . $token);
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
        if (count($_GET) != 4)
        {
            return redirect()->route('payment.fail');
        }
        if (isset($request->success) && isset($request->status))
        {
            if ($request->success == 1 && in_array($request->status, [1, 2]) && isset($request->trackId) && isset($request->orderId))
            {
                $token = $request->trackId;
                $invoice_model = new Invoice();
                $invoice = $invoice_model->find_for_verify(bank_token: $token);
                if (!$invoice)
                {
                    return redirect()->route('payment.fail');
                }
                $payment_method = PaymentMethod::where('code', 'zibal')
                    ->where('status', true)->first();
                if (!$payment_method)
                {
                    return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
                }

                $payload =json_encode(array(
                    'merchant' => $payment_method->merchant,
                    'trackId' => $invoice->bank_invoice_token
                ));
                try {
                    $zibal_service = new Zibal();
                    $req = $zibal_service->send_request('verify', $payload);
                    $response = json_decode($req);
                    if($response->result == 100) {
                        $invoice->payment_status = true;
                        $invoice->invoice_status_id = InvoiceStatus::get_status(code: 'paid');
                        $invoice->bank_trans_id = $response->refNumber;
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
