<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check())
        {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
            'mobile' => 'bail|required|digits:11|unique:users,mobile,' . $this->user->id,
            'email' => 'bail|nullable|email',
            'is_active' => 'bail|required|boolean',
            'authenticated' => 'bail|required|boolean',
            //'subscribe' => 'bail|required|boolean',
            //'ban' => 'bail|required|boolean',
            'national_code' => 'bail|nullable|digits:10',
            'zip_code' => 'bail|nullable|digits:10',
            'province_id' => 'bail|nullable|integer|exists:provinces,id',
            'role_id' => 'bail|integer|exists:roles,id',
            'city' => 'bail|nullable|string',
            'address' => 'bail|nullable|string',
            'password' => 'bail|nullable|string|min:8',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام کاربر',
            'role_id' => 'سطح کاربر',
            'mobile' => 'موبایل',
            'email' => 'ایمیل',
            'zip_code' => 'کد پستی',
            'address' => 'آدرس',
            'national_code' => 'کد ملی',
            'province_id' => 'استان',
            'city' => 'شهر',
            'password' => 'رمز عبور',
            'authenticated' => 'احراز هویت کاربر',
            'is_active' => 'وضعیت کاربر',
        ];
    }
}
