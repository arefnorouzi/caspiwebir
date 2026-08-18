<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLog;
use App\Models\InvoiceStatus;
use App\Models\Product;
use App\Models\ShopSetting;
use App\Services\Gateway\SepService;
use App\Services\InvoiceStepService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SepController extends Controller
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
            $sep_service = new SepService();
            $result = $sep_service->get_token(
                amount: $invoice->amount, invoice_id: $invoice->id, mobile: $invoice->customer_mobile
            );
            if (!$result)
            {
                return redirect('/checkout')->with("error", "خطا در برقراری ارتباط با درگاه پرداخت.");
            }
            if (isset($result['status']) && $result["status"] == 1) {
                $token = $result["token"];
                $invoice->bank_invoice_token = $token;
                $invoice->update();
                return redirect("https://sep.shaparak.ir/OnlinePG/SendToken?token=$token");
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            InvoiceLog::create([
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'title' => "خطا در ایجاد تراکنش بانک سامان",
                'log_data' => json_encode([
                    'message' => substr(strtok($e->getMessage(), '('), 0, 250),
                ]),
                'log_time' => now(),
            ]);
        }
        return redirect('/checkout')
            ->with("error", "خطا در ارتباط با درگاه بانکی. لطفا درگاه بانکی دیگری را انتخاب نمایید");
    }

    public function verify(Request $request)
    {
        Log::info("sep callback");
        Log::info($request);
        if (isset($request->ResNum) && isset($request->Status) && isset($request->RefNum))
        {
            // confirmtransaction
            $invoice_id = intval($request->ResNum);
            $ref_num = trim($request->RefNum);
            try {
                $invoice = Invoice::where('payment_status', false)
                    ->where('id', $invoice_id)->first();
                if (!$invoice)
                {
                    return redirect()->route('payment.fail');
                }
                $sep_service = new SepService();
                $result = $sep_service->verify($ref_num);
                if ($result['Success']) {
                    Log::info("sep callback was ok");
                    $invoice_status = InvoiceStatus::get_status(code: 'paid');
                    if ($invoice_status)
                    {
                        $invoice->invoice_status_id = $invoice_status;
                        InvoiceStepService::store_step($invoice, $invoice_status);
                    }

                    $invoice->payment_status = true;
                    $invoice->purchased_at = now();
                    $invoice->bank_payment_code = $ref_num;
                    $invoice->bank_trans_id = $request->TraceNo;
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


                    $invoice->load('items');
                    foreach ($invoice->items as $item)
                    {
                        if ($item->product_id && isset($item->product))
                        {
                            try {
                                $product = Product::where('id', '=', $item->product_id)
                                    ->firstOrFail();
                                $product->sales += $item->qty;
                                // $product->stock = max(0, $product->stock - $item->qty);
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
        }

        return redirect()->route('payment.fail');
    }
}
