<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRolePriceRequest extends FormRequest
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
            'role_id' => 'bail|required|integer|exists:roles,id',
            'product_id' => 'bail|required|integer|exists:products,id',
            'price' => 'bail|required|integer|min:100',
            'offer_price' => 'bail|nullable|integer|min:0|lt:price',
            'offer_end_date' => 'bail|nullable|date',
        ];
    }
}
