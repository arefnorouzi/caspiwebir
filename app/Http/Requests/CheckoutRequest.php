<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|min:3|max:100',
            'mobile' => 'bail|required|digits:11|starts_with:09',
            'address' => 'bail|nullable|string|min:3|max:100',
            'note' => 'bail|nullable|string|min:2|max:250',
            'national_code' => 'bail|nullable|digits:10',
            'zip_code' => 'bail|nullable|digits:10',
            'city' => 'bail|nullable|string|min:2|max:100',
            'province_id' => 'bail|nullable|integer|exists:provinces,id',
            'payment_method_id' => 'bail|required|integer|exists:payment_methods,id',
            'shipping_method_id' => 'bail|required|integer|exists:shipping_methods,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام و نام خانوادگی',
            'mobile' => 'موبایل',
            'address' => 'آدرس',
            'note' => 'یادداشت مشتری',
            'national_code' => 'کد ملی',
            'zip_code' => 'کد پستی',
            'city' => 'شهر',
            'province_id' => 'استان',
            'shipping_method_id' => 'روش ارسال',
            'payment_method_id' => 'روش پرداخت',
        ];
    }

    public function prepareForValidation(): void
    {
        if (!isset($this->name))
        {
            $this->merge([
                'name' => 'کاربر مهمان',
            ]);
        }
        if (!isset($this->province_id)){
            $this->merge(['province_id' => 1]);
        }

        if (!isset($this->shipping_method_id)){
            $this->merge(['shipping_method_id' => 1]);
        }
        if (!isset($this->payment_method_id)){
            $this->merge(['payment_method_id' => 1]);
        }

    }
}
