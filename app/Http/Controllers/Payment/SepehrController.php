<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\SepehrCallbackRequest;
use App\Models\Invoice;
use App\Models\InvoiceLog;
use App\Models\InvoiceStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShopSetting;
use App\Services\InvoiceStepService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SepehrController extends Controller
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
            $payment_method = PaymentMethod::where('code', 'sepehr')
                ->where('status', true)->first();
            if (!$payment_method)
            {
                return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
            }
            $TerminalID = $payment_method->terminal_id;
            $callback_url = route('payment.sepehr.callback');
            $amount = intval($invoice->amount);
            $params ='terminalID='.$TerminalID.'&Amount='.$amount.'&callbackURL='.urlencode($callback_url).'&invoiceID='.$invoice->id;

            $url = "https://sepehr.shaparak.ir/Rest/V1/PeymentApi/GetToken";
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close ($ch);

            $result = json_decode($response, true);
            if ($result && $result["Status"] == 0) {
                $token = $result["Accesstoken"];
                $invoice->bank_invoice_token = $token;
                $invoice->update();
                return view('payment.sepehr', [
                    'terminal_id' => $TerminalID, 'token' => $token]);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return redirect('/checkout')
            ->with("error", "خطا در ارتباط با درگاه بانکی. لطفا درگاه بانکی دیگری را انتخاب نمایید");
    }


    public function verify(SepehrCallbackRequest $request)
    {
        Log::info("sepehr callback");
        Log::info($request);
        $validatedData = $request->validated();
        Log::info("sepehr validated");
        $digitalreceipt = $validatedData["digitalreceipt"];
        $invoice_id = intval($validatedData["invoiceid"]);
        try {
            $invoice = Invoice::where('payment_status', false)
                ->where('id', $invoice_id)->first();
            if (!$invoice)
            {
                return redirect()->route('payment.fail');
            }
            $payment_method = PaymentMethod::where('code', 'sepehr')
                ->where('status', true)->first();
            if (!$payment_method)
            {
                return redirect()->route('payment.fail');
            }
            $TerminalID = $payment_method->terminal_id;

            $params ='digitalreceipt='.$digitalreceipt.'&Tid='.$TerminalID;
            $url = "https://sepehr.shaparak.ir/Rest/V1/PeymentApi/Advice";
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close ($ch);
            $result = json_decode($response, true);
            if (strtoupper($result['Status']) == 'OK') {
                Log::info("sepehr callback was ok");
                $invoice_status = InvoiceStatus::get_status(code: 'paid');
                if ($invoice_status)
                {
                    $invoice->invoice_status_id = $invoice_status;
                    InvoiceStepService::store_step($invoice, $invoice_status);
                }
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
                // sms
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

                $invoice->load('items');
                foreach ($invoice->items as $item)
                {
                    if ($item->product_id && isset($item->product))
                    {
                        try {
                            $product = Product::where('id', '=', $item->product_id)
                                ->firstOrFail();
                            $product->sales += $item->qty;
                            //$product->stock = max(0, $product->stock - $item->qty);
                            $product->update();
                        }
                        catch (\Exception $e)
                        {
                            Log::error($e->getMessage());
                        }
                    }
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
