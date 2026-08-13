<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:70',
            'mobile' => 'bail|required|digits:11',
            'phone' => 'bail|nullable|digits:11',
            'email' => 'bail|nullable|string|max:70',
            'national_code' => 'bail|nullable|digits:10',
            'province_id' => 'bail|nullable|integer|exists:provinces,id',
            'city' => 'bail|nullable|string|min:2|max:50',
            'address' => 'bail|nullable|string|min:2|max:220',
            'zip_code' => 'bail|nullable|digits:10',
        ];
    }
}
