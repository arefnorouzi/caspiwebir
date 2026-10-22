<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\MobileLoginRequest;
use App\Http\Requests\Mobile\MobileRegisterRequest;
use App\Http\Requests\MobileAuthRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Models\User;
use App\Services\VerifyCodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MobileAuthController extends Controller
{
    public function legacy_login()
    {
        if (auth()->check())
        {
            return redirect()->intended('dashboard');
        }

        return Inertia::render('auth/LegacyLogin');
    }

    public function otp_login()
    {
        if (auth()->check())
        {
            return redirect()->intended('dashboard');
        }

        return Inertia::render('auth/Login');
    }

    public function login(MobileLoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = [
            'mobile' => $validated['mobile'],
            'password' => $validated['password'],
        ];
        $user = User::withTrashed()->where('mobile', $validated['mobile'])->first();
        if ($user && ($user->deleted_at || $user->ban))
        {
            return response()->json([
                'successful' => false,
                'error' => 'حساب کاربری شما مسدود شده.'
            ], 400);
        }
        if (!Auth::attempt($credentials, true)) {
            return response()->json([
                'successful' => false,
                'error'=> 'کاربری با این مشخصات پیدا نشد.'
            ], 400);
        }
        auth()->login($user, true);
        //$request->session()->regenerate();

        return response()->json([
            'successful' => true,
            'message' => 'ورود با موفقیت انجام شد.',
            'url' => $request->session()->pull(
                'url.intended',
                route('dashboard.index')
            )
        ]);
        //return redirect($redirectTo);
    }

    public function register(MobileRegisterRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'password' => Hash::make($validated['password']),
            ]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors([
                'mobile' => 'اطلاعات وارد شده نامعتبر است.',
            ]);
        }

        auth()->login($user, true);
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }
    public function authenticate(MobileAuthRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::withTrashed()->where('mobile', $validated['mobile'])->first();
            if ($user && ($user->deleted_at || $user->ban))
            {
                return response()->json(['message' => 'حساب کاربری شما مسدود شده است.'], status: 403);
            }
            if (!$user)
            {
                $pass = rand(12345678, 987654321);
                $user = User::create([
                    'mobile' => $validated['mobile'],
                    'password' => bcrypt("$pass"),
                    'referral_code' => $validated['mobile']
                ]);

            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => 'اطلاعات وارد شده نامعتبر است.'], status: 400);
        }
        $verify_code_service = new VerifyCodeService();
        try {
            $verify_code_request = $verify_code_service->sendVerifyCode(
                uid: $user->id, recipient: $user->mobile
            );
            if ($verify_code_request['status'])
            {
                return response()->json(['message' => $verify_code_request['message']]);
            }
            return response()->json(['message' => $verify_code_request['message']], status: 400);

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return response()->json(['message' => 'اطلاعات وارد شده نامعتبر است.'], status: 400);

    }

    public function verify_code(VerifyCodeRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::where('mobile', $validated['mobile'])->firstOrFail();
            $verify_code_service = new VerifyCodeService();
            $req = $verify_code_service->verifyCode(
                uid: $user->id, recipient: $user->mobile, code: $validated['code'], type: $validated['type']
            );
            if ($req['status'])
            {
                if (!$user->mobile_verified)
                {
                    $user->mobile_verified = true;
                    $user->update();
                }
                auth()->login($user, true);
                return response()->json([
                    'successful' => true,
                    'message' => 'ورود با موفقیت انجام شد.',
                    'url' => $request->session()->pull(
                        'url.intended',
                        route('dashboard.index')
                    )
                ]);
            }
            else{
                return response()->json([
                    'successful' => false,
                    'error' => 'کد تایید نامعتبر است.'
                ], status: 400);

            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return response()->json([
            'successful' => false,
            'error' => 'اطلاعات وارد شده نامعتبر است.'
        ], status: 400);

    }

}
