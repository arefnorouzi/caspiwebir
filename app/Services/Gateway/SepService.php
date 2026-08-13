<?php

namespace App\Services\Gateway;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class SepService
{

    public function get_token(int $amount, $invoice_id, $mobile)
    {
        $payment_method = PaymentMethod::where('code', 'sep')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return null;
        }
        $mobile = substr($mobile, 1);
        $url = "https://sep.shaparak.ir/onlinepg/onlinepg";
        $headers = [
            "Content-Type: application/json",
        ];
        $request_body = json_encode([
            "action" => "token",
            "TerminalId" => $payment_method->terminal_id,
            "Amount" => $amount,
            "ResNum" => "$invoice_id",
            "RedirectUrl" => route('payment.sep.callback'),
            "CellNumber" => $mobile
        ]);
        return $this->send_request(url: $url, payload: $request_body, headers: $headers);
    }

    public function verify(string $ref_num)
    {
        $payment_method = PaymentMethod::where('code', 'sep')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return null;
        }
        $url = "https://sep.shaparak.ir/verifyTxnRandomSessionkey/ipg/VerifyTransaction";
        $headers = [
            "Content-Type: application/json"
        ];
        $request_body = json_encode([
            "RefNum" => $ref_num,
            "TerminalNumber" => $payment_method->terminal_id
        ]);
        return $this->send_request(url: $url, payload: $request_body, headers: $headers);
    }
    public function send_request($url, $payload, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch,CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close ($ch);
        return json_decode($response, true);
    }
}
