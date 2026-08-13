<?php

namespace App\Services;

use App\Models\SmsSetting;
use Illuminate\Support\Facades\Log;
use Melipayamak;

class SmsService
{
    public static function send_verify_code($to, $code): void
    {
        $sms_setting = SmsSetting::where('code', 'verify_code')
            ->where('status', true)->first();
        if ($sms_setting)
        {
            $sms_data = [
                'body_id' => $sms_setting->pattern_id,
                'to' => $to,
                'message' => ["$code"],
            ];
            self::send_with_pattern(data: $sms_data);
        }
    }

    public static function invoice_sms($to, $invoice_number, $status): void
    {
        $sms_setting = SmsSetting::where('code', 'invoice')
            ->where('status', true)->first();
        if ($sms_setting)
        {
            $sms_data = [
                'body_id' => $sms_setting->pattern_id,
                'to' => $to,
                'message' => ["$invoice_number", $status],
            ];
            self::send_with_pattern(data: $sms_data);
        }

    }

    public static function send_with_pattern(array $data): void
    {

        $username = env('MELIPAYAMAK_USERNAME');
        $password = env('MELIPAYAMAK_PASSWORD');

        $api = new Melipayamak\MelipayamakApi($username, $password);
        $smsSoap = $api->sms('soap');
        try {
            $smsSoap->sendByBaseNumber($data['message'], $data['to'], $data['body_id']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public static function send_with_pattern_raygan_sms(array $data): void
    {
        // todo
    }
}
