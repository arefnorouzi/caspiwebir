<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SimpleLoginRequest;
use App\Http\Requests\Auth\SimpleRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function register(SimpleRegisterRequest $request): object
    {
        $validated = $request->validated();
        try {
            $user = User::create([
                'mobile' => $validated['mobile'],
                'password' => bcrypt($validated['password']),
            ]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => config('messages.invalid_register')
            ], 400);
        }
        auth()->login($user, true);
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    public function login(SimpleLoginRequest $request): object
    {
        $validated = $request->validated();
        try {
            $user = User::where('mobile', $validated['mobile'])
                ->where('ban', false)
                ->where('is_active', true)
                ->firstOrFail();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => config('messages.invalid_authentication')
            ], 400);
        }
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'error' => config('messages.invalid_authentication')
            ], 400);
        }
        auth()->login($user, true);
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'created_at' => $user->created_at,
            ]
        ]);
    }
}
