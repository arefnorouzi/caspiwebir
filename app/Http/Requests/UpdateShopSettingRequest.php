<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->check()){
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
            'name' => 'bail|required|string|max:150',
            'meta' => 'bail|nullable|string|max:157',
            'email' => 'bail|nullable|email|max:70',
            'phone' => 'bail|nullable|string|max:50',
            'address' => 'bail|nullable|string|max:250',
            'factor_logo' => 'bail|nullable|string|max:250',
            'zip_code' => 'bail|nullable|string|max:10',
            'tax' => 'bail|required|integer|min:0|max:100',
            'sell_status' => 'bail|required|boolean',
            'order_expire' => 'bail|required|integer|min:1|max:720',
            'stock_alert' => 'bail|required|integer|min:1|max:10',

        ];
    }
}
