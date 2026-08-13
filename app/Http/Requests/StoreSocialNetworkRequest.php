<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSocialNetworkRequest extends FormRequest
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
            'name' => 'bail|required|string|min:2|max:100',
            'link' => 'bail|nullable|url|min:10|max:100',
            'image' => 'bail|nullable|string|min:15|max:250',
            'status' => 'bail|required|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام',
            'link' => 'لینک',
            'image' => 'عکس',
        ];
    }
}
