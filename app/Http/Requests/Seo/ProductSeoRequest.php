<?php

namespace App\Http\Requests\Seo;

use Illuminate\Foundation\Http\FormRequest;

class ProductSeoRequest extends FormRequest
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
            'seo_title' => 'bail|required|string|max:70',
            'seo_meta' => 'bail|nullable|string|max:70',
            'seo_keywords' => 'bail|nullable|string|max:70',
            'seo_tags' => 'bail|nullable|string|max:70',
        ];
    }
}
