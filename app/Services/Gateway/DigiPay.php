<?php

namespace App\Services\Gateway;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class DigiPay
{

    //private string $base_url = 'https://uat.mydigipay.info/digipay/api/'; // staging
    private string $base_url = 'https://api.mydigipay.com/digipay/api/'; // production

    public function get_token()
    {

        $payment_method = PaymentMethod::where('code', 'digipay')
            ->where('status', true)->first();
        if (!$payment_method)
        {
            return null;
        }
        $header_secret = base64_encode("$payment_method->terminal_id:$payment_method->merchant");

        //$url = 'https://uat.mydigipay.info/digipay/api';
        $payload = [
            'username' => $payment_method->username,
            'password' => $payment_method->password,
            'grant_type' => 'password',
        ];
        $res_data = $this->send_request(action: 'oauth/token', payload: $payload, header_token: $header_secret);
        return $res_data;
    }

    public function credit($invoice, $type=11, $preferredGateway = 2)
    {
        $header_secret = '';
        $token_data = $this->get_token();
        if ($token_data)
        {
            $header_secret = $token_data['access_token'];
        }
        $items = [];
        foreach ($invoice->items as $item)
        {
            $items[] = [
                "sellerId" => $item->id,
                "supplierId" => $item->id,
                "productCode" => $item->product_id,
                "brand" => $item->product->brand_id,
                "productType" => 2,
                "count" => $item->qty,
                "categoryId" => $item->product_id,
            ];
        }
        $payload = json_encode([
            'amount' => intval($invoice->amount * 10),
            'cellNumber' => $invoice->customer_mobile,
            'providerId' => $invoice->id,
            'callbackUrl' => route('payment.digipay.callback'),
            'basketDetailsDto' => [
                'basketId' => $invoice->id,
                'items' => $items
            ],
            'additionalInfo' => [
                "preferredGateway" => $preferredGateway,
            ]
        ]);
        $res_data = $this->send_request(action: "tickets/business?type=$type", payload: $payload, header_token: $header_secret);
        return $res_data;
    }

    public function verify($invoice, $tracking_code)
    {
        $header_secret = '';
        $token_data = $this->get_token();
        if ($token_data)
        {
            $header_secret = $token_data['access_token'];
        }

        $payload = json_encode([
            'trackingCode' => $tracking_code,
            'providerId' => $invoice->id,
        ]);
        $res_data = $this->send_request(action: 'purchases/verify?type=11', payload: $payload, header_token: $header_secret);
        return $res_data;
    }

    protected function send_request($action, $payload, $header_token = '')
    {
        if ($action != 'oauth/token')
        {
            $headers_data = [
                'Agent: WEB',
                'Digipay-Version: 2022-02-02',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $header_token,
            ];
        }
        else{
            $headers_data = [
                'Authorization: Basic ' . $header_token,
            ];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $action);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        if ($response === false) {
            Log::error(curl_error($ch));
        } else {
            // Get the HTTP status code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            Log::info("HTTP Status Code: " . $httpCode);
        }
        Log::info($response);
        curl_close($ch);
        return json_decode($response, true);
    }


}
