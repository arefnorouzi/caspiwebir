<?php

namespace App\Services;

use App\Models\VerifyCode;
use Illuminate\Support\Facades\Log;

class VerifyCodeService
{
    public function sendVerifyCode(int $uid, string $recipient, string $type = 'sms'): array
    {
        $now = time();
        $verify_code_model = VerifyCode::where('user_id', $uid)
            ->where('type', $type)->where('expired_at', '>', $now)->orderBy('id', 'desc')
            ->first();
        if ($verify_code_model) {
            $seconds = max(0, intval($now - $verify_code_model->generated_at));

            return [
                'status' => false,
                'message' => 'کد تایید '.$seconds.' ثانیه قبل برای شما ارسال شده است. لطفا منتظر بمانید.',
            ];
        }
        $code = rand(1024, 9876);
        $expired_seconds = 120;
        if ($type == 'email') {
            $expired_seconds = 600;
        }
        try {
            VerifyCode::create([
                'user_id' => $uid, 'type' => $type, 'recipient' => $recipient,
                'expired_at' => time() + $expired_seconds, 'code' => $code,
                'generated_at' => $now,
            ]);

            SmsService::send_verify_code(to: $recipient, code: $code);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return [
                'status' => false,
                'message' => 'خطایی در ارسال کد تایید رخ داد. لطفا دوباره امتحان کنید.',
            ];
        }

        return [
            'status' => true,
            'message' => 'کد تایید به '.$recipient.' ارسال شد.',
        ];
    }

    public function verifyCode($uid, $recipient, $code, $type = 'sms'): array
    {
        try {
            $verify_code = VerifyCode::where('user_id', $uid)
                ->where('type', $type)->where('code', $code)->where('recipient', $recipient)
                ->where('expired_at', '>', time())->orderBy('id', 'desc')
                ->firstOrFail();
            $verify_code->delete();

            return [
                'status' => true,
                'message' => 'کد تایید معتبر است.',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'کد تایید نامعتبر است.',
            ];
        }
    }
}
