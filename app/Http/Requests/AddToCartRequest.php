<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'product_id' => 'bail|required|integer|min:1|exists:products,id',
            'product_variant_id' => 'bail|nullable|integer|min:1|exists:product_variants,id',
            'qty' => 'required|integer|min:1',
        ];
    }

    public function prepareForValidation(): void
    {
        if (!isset($this->qty)){
            $this->merge(['qty' => 1]);
        }

    }

    public function attributes()
    {
        return [
            'product_id' => 'شناسه محصول',
            'product_variant_id' => 'شناسه محصول متغیر',
            'qty' => 'تعداد',
        ];
    }
}
