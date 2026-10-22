<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\ChoosePaymentMethodRequest;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {

    }

    public function choose_payment_method(ChoosePaymentMethodRequest $request)
    {
        $request = $request->validated();
        try {
            $paymentMethod = PaymentMethod::where('id', $request['payment_method_id'])
                ->where('status', 1)->firstOrFail();
            $invoice_model = new Invoice();
            $invoice = $invoice_model->find_for_pay($request['invoice_id']);
            if (!$invoice) {
                return response()->json(['message' => 'فاکتور پیدا نشد'], 404);
            }
            $invoice->confirmed_by_user = true;
            $invoice->payment_method_id = $paymentMethod->id;
            if ($paymentMethod->interest_rate)
            {
                $invoice->interest_amount = $invoice->amount * ($paymentMethod->interest_rate / 100);
            }
            $invoice->update();
            if ($paymentMethod->code == 'zarinpal')
            {
                return response()->json(['link' => route('payment.zarinpal.pay', $invoice->id)]);
            }
            elseif ($paymentMethod->code == 'zibal')
            {
                return response()->json(['link' => route('payment.zibal.pay', $invoice->id)]);
            }
            elseif ($paymentMethod->code == 'bpm')
            {
                return response()->json(['link' => route('payment.bpm.pay', $invoice->id)]);
            }
            elseif ($paymentMethod->code == 'sadad')
            {
                return response()->json(['link' => route('payment.sadad.pay', $invoice->id)]);
            }
            elseif ($paymentMethod->code == 'torob')
            {
                return response()->json(['link' => route('payment.torob.pay', $invoice->id)]);
            }
            elseif ($paymentMethod->code == 'snapppay')
            {
                return response()->json(['link' => route('payment.snapp.pay', $invoice->id)]);
            }
            elseif ($paymentMethod->code == 'digipay')
            {
                return response()->json(['link' => route('payment.digipay.pay', $invoice->id)]);
            }
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'سرویس پرداخت موردنظر در دسترس نیست. لطفا روش دیگری را انتخاب نمایید'], 500);
        }
        return response()->json(['message' => 'سرویس پرداخت موردنظر در دسترس نیست. لطفا روش دیگری را انتخاب نمایید'], 500);

    }

    public function success_payment()
    {
        return view('payment.success');
    }

    public function error_payment()
    {
        return view('payment.fail');
    }
}
