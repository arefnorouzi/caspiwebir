<?php

namespace App\Services\Gateway;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class SnappPayService
{
    protected string $baseUrl = 'https://fms-gateway-staging.apps.public.okd4.teh-1.snappcloud.io/';

    public function get_token()
    {
        $payment_method = PaymentMethod::where('code', 'snapppay')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return null;
        }
        $url = $this->baseUrl . 'api/online/v1/oauth/token';
        $headers = [
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic ".  base64_encode($payment_method->terminal_id. ":" . $payment_method->merchant)
        ];
        $request_body = "username=$payment_method->username&password=$payment_method->password&grant_type=password&scope=online-merchant";
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
        Log::info($response);
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

    public function settle($payment_token, $access_token)
    {
        $url = $this->baseUrl . 'api/online/payment/v1/settle';
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
        if ($response === false) {
            Log::error(curl_error($ch));
        } else {
            // Get the HTTP status code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            Log::info("HTTP Status Code: " . $httpCode);
        }
        curl_close ($ch);
        Log::info($response);
        return json_decode($response, true);
    }
}
