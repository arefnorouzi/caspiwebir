<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
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
            'name' => 'bail|required|string|max:150',
            'meta' => 'bail|nullable|string|max:250',
            'sku' => 'bail|required|string|unique:product_variants,sku',
            'code' => 'bail|nullable|string|max:250',
            'image' => 'bail|nullable|string|max:250',
            'stock' => 'bail|required|integer|min:0',
            'price' => 'bail|required|integer|min:0',
            'offer_price' => 'bail|nullable|integer|min:0|lt:price',
            'offer_end_date' => 'bail|nullable|date|after:today',
            'status' => 'bail|required|boolean',
            'is_default' => 'bail|required|boolean',
            'product_id' => 'bail|required|integer|exists:products,id',
        ];
    }
}
