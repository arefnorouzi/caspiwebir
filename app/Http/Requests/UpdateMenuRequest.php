<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'name' => 'bail|required|string|max:255',
            'slug' => 'bail|required|string|max:255',
            'status' => 'bail|required|boolean',
            'rank' => 'bail|required|integer|min:1|max:100',
            'parent_id' => 'bail|nullable|integer|exists:menus,id',
        ];
    }
}
