<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductSliderRequest extends FormRequest
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
            'name' => 'bail|required|string|max:100',
            'link' => 'bail|nullable|string|max:200',
            'status' => 'bail|required|boolean',
            'product_limit' => 'bail|required|integer|min:5|max:12',
            'position' => 'bail|required|integer|min:0|max:20',
            'page_section_id' => 'bail|nullable|integer|exists:page_sections,id',
            'background_color' => 'bail|nullable|string',
            'text_color' => 'bail|nullable|string',
        ];
    }
}
