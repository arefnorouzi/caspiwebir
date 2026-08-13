<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'image' => 'bail|required|string|max:250',
            'status' => 'bail|required|boolean',
            'new_tab' => 'bail|required|boolean',
            'rank' => 'bail|required|integer',
            'position' => 'bail|required|integer',
            'page_section_id' => 'bail|nullable|integer|exists:page_sections,id',
            'size' => 'bail|required|integer',
        ];
    }
}
