<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShopSetting;
use App\Services\Gateway\Sadad;
use App\Services\InvoiceStepService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SadadController extends Controller
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
            $payment_method = PaymentMethod::where('code', 'sedad')
                ->where('status', true)->first();
            if (!$payment_method)
            {
                return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
            }
            $sedad_service = new Sadad();
            $key = $payment_method->password;
            $MerchantId = $payment_method->merchant;
            $TerminalId = $payment_method->terminal_id;
            $Amount = intval($invoice->amount * 10); //YourAmount (Rials)
            $OrderId = "$invoice->id";
            $LocalDateTime = date("m/d/Y g:i:s a");
            $ReturnUrl = route('payment.sedad.callback');
            $SignData = $sedad_service->encrypt_pkcs7("$TerminalId;$OrderId;$Amount", "$key");

            $data = array(
                'TerminalId' => $TerminalId,
                'MerchantId' => $MerchantId,
                'Amount' => $Amount,
                'SignData' => $SignData,
                'ReturnUrl' => $ReturnUrl,
                'LocalDateTime' => $LocalDateTime,
                'OrderId' => $OrderId
            );

            $result = $sedad_service->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest', $data);
            if($result->ResCode == 0)
            {
                $Token = $result->Token;
                $invoice->bank_invoice_token = $Token;
                $invoice->update();
                $url = "https://sadad.shaparak.ir/VPG/Purchase?Token=$Token";
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

    public function verify(Request $request)
    {
        if (isset($request['OrderId']) && isset($request['token']) && isset($request["ResCode"]))
        {
            try {

                $OrderId = $_POST["OrderId"];
                $Token = $_POST["token"];
                $ResCode = $_POST["ResCode"];
                Log::info("sedad callback for order: $OrderId");
                $invoice_model = new Invoice();
                $invoice = $invoice_model->find_for_verify(bank_token: $Token);
                if (!$invoice)
                {
                    return redirect()->route('payment.fail');
                }

                $sedad_service = new Sadad();
                if ($ResCode == 0) {
                    $payment_method = PaymentMethod::where('code', 'sedad')
                        ->where('status', true)->first();
                    if (!$payment_method)
                    {
                        return redirect()->route('payment.fail');
                    }
                    $key = $payment_method->password;

                    $verifyData = array(
                        'Token' => $Token,
                        'SignData' => $sedad_service->encrypt_pkcs7($Token, $key)
                    );

                    $result = $sedad_service->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify', $verifyData);
                    if ($result->ResCode == 0) {
                        Log::info("sedad callback was ok");
                        $invoice_status = InvoiceStatus::get_status(code: 'paid');
                        if ($invoice_status)
                        {
                            $invoice->invoice_status_id = $invoice_status;
                            InvoiceStepService::store_step($invoice, $invoice_status);
                        }
                        $invoice->bank_payment_code = $result->SystemTraceNo;
                        $invoice->payment_status = true;
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
