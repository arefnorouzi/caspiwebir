<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GroupDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check()) {
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
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
            'discount_type' => 'bail|required|in:percent,fixed',
            'discount_value' => 'bail|required|numeric|min:1',
            'offer_end_date' => 'bail|nullable|date|after:today',
            'min_price' => 'bail|nullable|integer',
            'max_off_amount' => 'bail|nullable|integer'
        ];
    }
}
