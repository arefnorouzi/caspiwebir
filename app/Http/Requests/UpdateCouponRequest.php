<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'bail|required|string|max:50|unique:coupons,code,' . $this->coupon->id,
            'coupon_type' => 'bail|required|string|max:50',
            'value' => 'bail|required|integer|min:1',
            'min_purchase' => 'bail|nullable|integer|min:1000',
            'max_usage' => 'bail|nullable|integer|max:10000',
            'starts_at' => 'bail|nullable|date',
            'expires_at' => 'bail|nullable|date|after:starts_at',
            'active' => 'bail|nullable|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'کد',
            'type' => 'نوع تخفیف',
            'value' => 'مقدار تخفیف',
            'min_purchase' => 'حداقل سفارش',
            'max_usage' => 'تعداد کوپن',
            'starts_at' => 'تاریخ شروع',
            'expires_at' => 'تاریخ انقضا',
            'active' => 'وضعیت',
        ];
    }
}
