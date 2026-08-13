<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePageSectionRequest extends FormRequest
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
            'name' => 'bail|required|min:2|max:255',
            'gap' => 'bail|required|integer|min:1|max:10',
            'xl_columns' => 'bail|required|integer|min:1|max:10',
            'lg_columns' => 'bail|required|integer|min:1|max:10',
            'md_columns' => 'bail|required|integer|min:1|max:10',
            'sm_columns' => 'bail|required|integer|min:1|max:10',
            'xs_columns' => 'bail|required|integer|min:1|max:10',
            'background_color' => 'bail|nullable|string|min:1|max:10',
            'text_color' => 'bail|nullable|string|min:1|max:10',
            'show_name' => 'bail|required|boolean',
            'status' => 'bail|required|boolean',
        ];
    }
}
