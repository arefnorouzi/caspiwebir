<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\SnappPayCallbackRequest;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\ShopSetting;
use App\Services\Gateway\SnappPayService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SnappPayController extends Controller
{
    public function pay($id)
    {
        $invoice_model = new Invoice();
        $invoice = $invoice_model->find_for_pay($id);
        if (!$invoice)
        {
            return redirect('/checkout')->with("error", "فاکتور برای پرداخت پیدا نشد");
        }
        try {
            $snapp_pay_service = new SnappPayService();
            $token_request = $snapp_pay_service->get_token();
            if (!$token_request)
            {
                Log::info("error in get token");
                return redirect('/checkout')
                    ->with("error", "خطا در ارتباط با درگاه بانکی. لطفا درگاه بانکی دیگری را انتخاب نمایید");
            }
            $Amount = intval($invoice->amount * 10); //YourAmount (Rials)
            $eligible_request = $snapp_pay_service->eligible(
                amount: $Amount, access_token: $token_request['access_token']
            );
            if (!$eligible_request || !isset($eligible_request['successful']) || !$eligible_request['successful'])
            {
                return redirect('/checkout')
                    ->with("error", "امکان پرداخت اقساطی برای این فاکتور وجود ندارد.");
            }

            $items = [];
            foreach ($invoice->items() as $item)
            {
                $items[] = [
                    "id" => $item->id,
                    "name" => $item->name,
                    "count" => $item->qty,
                    "amount" => intval($item->unit_price * 10),
                    "category" => $item->brand->name,
                    "commissionType" => "1"
                ];
            }


            $cart = [
                "cartId" => "$invoice->id",
                "totalAmount" => intval($invoice->amount * 10),
                "taxAmount" => 0,
                "shippingAmount" => intval($invoice->shipping_cost * 10),
                "isTaxIncluded" => true,
                "isShipmentIncluded" => true,
                "cartItems" => $items,
            ];
            $payload = json_encode([
                "amount" => $Amount,
                'discountAmount' => intval($invoice->discount * 10),
                'externalSourceAmount' => 0,
                "returnURL" => route('payment.snapp.callback'),
                //"returnURL" => "https://caspiweb.ir/payment/snapp/callback",
                "transactionId" => $invoice->uuid,
                "cartList" => [$cart],
                "mobile" => "+98" . substr($invoice->customer_mobile,1)
            ]);

            $result = $snapp_pay_service->get_payment_url(
                access_token: $token_request['access_token'], payload: $payload
            );

            if($result && isset($result['successful']) && $result['successful'])
            {
                $Token = $result["response"]["paymentToken"];
                $invoice->bank_invoice_token = $Token;
                $invoice->bank_payment_code = $token_request['access_token'];
                $invoice->update();
                $url = $result["response"]["paymentPageUrl"];
                return redirect($url);
            }
            else
            {
                Log::error($result);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return redirect('/checkout')
            ->with("error", "خطا در ارتباط با درگاه بانکی. لطفا درگاه بانکی دیگری را انتخاب نمایید");
    }

    public function verify(SnappPayCallbackRequest $request)
    {
        Log::info($request);
        $validated = $request->validated();
        if ($validated["state"] == "OK")
        {
            try {
                Log::info("snapppay callback was ok");
                $invoice = Invoice::where('payment_status', false)
                    ->where('id', intval($validated["transactionId"]))->first();
                if (!$invoice)
                {
                    return redirect()->route('payment.fail');
                }
                $snapp_pay_service = new SnappPayService();
                $verify_request = $snapp_pay_service->verify(
                    payment_token: $invoice->bank_invoice_token,access_token: $invoice->bank_payment_code
                );
                if ($verify_request && $verify_request['successful'])
                {

                    Log::info("snappay verified");

                    $settle_request = $snapp_pay_service->settle(
                        payment_token: $invoice->bank_invoice_token, access_token: $invoice->bank_payment_code
                    );
                    if ($settle_request && $settle_request['successful'])
                    {
                        $invoice->invoice_status_id = InvoiceStatus::get_status(code: 'paid');
                        $invoice->payment_status = true;
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
