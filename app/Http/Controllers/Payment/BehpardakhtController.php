<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\BehpardakhtCallbackRequest;
use App\Models\Invoice;
use App\Models\InvoiceLog;
use App\Models\InvoiceStatus;
use App\Models\PaymentMethod;
use App\Models\ShopSetting;
use App\Models\SmsNotification;
use App\Services\SmsService;
use App\Services\UserPlanService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BehpardakhtController extends Controller
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
            $payment_method = PaymentMethod::where('code', 'bpm')
                ->where('status', true)->first();
            if (!$payment_method)
            {
                return redirect('/checkout')->with("error", "درگاه انتخابی نامعتبر است");
            }

            require 'BPM_PGW.php';
            $pay_request = new \bpPayRequest();
            $pay_request->terminalId = intval($payment_method->terminal_id); //long
            $pay_request->userName = $payment_method->username; //string
            $pay_request->userPassword = $payment_method->password; //string
            $pay_request->orderId = $invoice->id; //long // Attention: Increase it per call
            $pay_request->amount = intval($invoice->amount * 10); //long
            $pay_request->localDate = date("Ymd");//string
            $pay_request->localTime = date("His"); //string
            $pay_request->additionalData = $invoice->uuid; //string
            $pay_request->callBackUrl = route('payment.bpm.callback'); //string // Attention:Replace it with your URL
            $pay_request->payerId = 0;//long
            $bpm_client = new \BPM();
            $bpPayRequestResponse = $bpm_client->bpPayRequest($pay_request);
            $res = $bpPayRequestResponse->return;
            $response = explode(',', $res);
            if ($response && $response['0'] == '0') {
                $token = $response[1];
                $invoice->bank_invoice_token = $token;
                $invoice->update();
                $mobile = '98' . substr($invoice->customer_mobile, 1, 10);
                return view('payment.bpm', ['RefId' => $token, 'mobile' => $mobile]);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return redirect('/checkout')
            ->with("error", "خطا در ارتباط با درگاه بانکی. لطفا درگاه بانکی دیگری را انتخاب نمایید");
   }


    public function verify(BehpardakhtCallbackRequest $request)
    {
        Log::info("behpardakhta callback");
        Log::info($request);
        $validatedData = $request->validated();
        if ($validatedData['ResCode'] == '0')
        {
            Log::info("behpardakht validated");
            $payment_method = PaymentMethod::where('code', 'bpm')
                ->where('status', true)->first();
            if (!$payment_method)
            {
                return redirect()->route('payment.fail');
            }
            $RefId = $validatedData["RefId"];
            $SaleOrderId = $validatedData["SaleOrderId"];
            $ResCode = $validatedData["ResCode"];
            $verifySaleReferenceId 	= $validatedData['SaleReferenceId'];
            try {
                $invoice = Invoice::where('payment_status', false)
                    ->where('bank_invoice_token', $RefId)->first();
                if (!$invoice)
                {
                    return redirect()->route('payment.fail');
                }

                require 'BPM_PGW.php';
                $verify_request = new \bpVerifyRequest();
                $verify_request->terminalId = intval($payment_method->terminal_id); //long
                $verify_request->userName = $payment_method->username; //string
                $verify_request->userPassword = $payment_method->password; //string
                $verify_request->orderId = $invoice->id; //long // Attention: Increase it per call
                $verify_request->saleOrderId = $SaleOrderId;
                $verify_request->saleReferenceId = $verifySaleReferenceId;
                $bpm_client = new \BPM();
                $bpPayRequestResponse = $bpm_client->bpVerifyRequest($verify_request);
                $res = $bpPayRequestResponse->return;
                $response = explode(',', $res);
                if ($response && $response['0'] == '0') {
                    Log::info("behpardakht callback was ok");
                    $invoice->bank_payment_code = $verifySaleReferenceId;
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
