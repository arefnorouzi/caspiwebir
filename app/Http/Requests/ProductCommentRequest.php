<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductCommentRequest extends FormRequest
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
            'description' => 'bail|required|string|max:255',
            'user_id' => 'bail|required|exists:users,id',
        ];
    }

    public function prepareForValidation(): void
    {
        if (!isset($this->user_id)){
            $this->merge(['user_id' => auth()->id()]);
        }

    }
}
