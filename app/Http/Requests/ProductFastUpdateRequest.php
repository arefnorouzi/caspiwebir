<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFastUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|min:3|max:255|unique:products,name,' .  $this->product->id,
            'price' => 'bail|required|integer|min:0',
            'offer_price' => 'bail|nullable|integer|min:0|lt:price',
            'offer_end_date' => 'bail|nullable|date|after:yesterday',
            'stock' => 'bail|required|integer|min:0',
            'status' => 'bail|required|boolean',
            'amazing' => 'bail|required|boolean',
            'pinned' => 'bail|required|boolean',
            'suggested' => 'bail|required|boolean',
            'image' => 'bail|nullable|string|max:255'
        ];
    }
}
