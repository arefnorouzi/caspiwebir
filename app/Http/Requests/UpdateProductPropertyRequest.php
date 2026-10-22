<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductPropertyRequest extends FormRequest
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
            'product_id' => 'bail|required|exists:products,id',
            'property_name' => 'bail|required|string|min:1|max:150',
            'property_value' => 'bail|required|string|min:1|max:250',
            'pinned' => 'bail|required|boolean',
            'property_status' => 'bail|required|boolean',
        ];
    }
}
