<?php

namespace App\Services\Gateway;

use App\Models\PaymentMethod;

class TorobPay
{
    protected string $baseUrl = 'https://cpg.torobpay.com/';

    public function get_token()
    {
        $payment_method = PaymentMethod::where('code', 'torob')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return null;
        }
        $url = $this->baseUrl . 'api/online/v1/oauth/token';
        $headers = [
            "Content-Type: application/json",
            "Authorization: Basic ".  base64_encode($payment_method->terminal_id. ":" . $payment_method->merchant)
        ];
        $request_body = json_encode([
            "username" => $payment_method->username,
            "password" => $payment_method->password
        ]);
        return $this->send_request(url: $url, payload: $request_body, headers: $headers);
    }

    public function eligible(int $amount, string $access_token)
    {
        $headers = [
            "Authorization: Bearer " . $access_token,
            "Content-Type: application/json"
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->baseUrl . "api/online/offer/v1/eligible?amount=$amount");
        curl_setopt($ch,CURLOPT_POST, 0);                //0 for a get request
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close ($ch);
        //Log::info($response);
        return json_decode($response, true);
    }

    public function get_payment_url($access_token, $payload)
    {
        $url = $this->baseUrl . 'api/online/payment/v1/token';
        $headers = [
            "Authorization: Bearer " . $access_token,
            "Content-Type: application/json"
        ];
        return $this->send_request(url: $url, payload: $payload, headers: $headers);
    }

    public function verify($payment_token, $access_token)
    {
        $url = $this->baseUrl . 'api/online/payment/v1/verify';
        $headers = [
            "Authorization: Bearer " . $access_token,
            "Content-Type: application/json"
        ];
        return $this->send_request(url: $url, payload: json_encode(["paymentToken" => $payment_token]), headers: $headers);
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
        //Log::info($response);
        return json_decode($response, true);
    }
}
