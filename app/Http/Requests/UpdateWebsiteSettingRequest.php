<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsiteSettingRequest extends FormRequest
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
            'name' => 'bail|required|string|max:150',
            'email' => 'bail|nullable|email|max:70',
            'meta' => 'bail|nullable|string|max:157',
            'phone' => 'bail|nullable|string|max:50',
            'mobile' => 'bail|nullable|string|max:50',
            'address' => 'bail|nullable|string|max:250',
            'enamad' => 'bail|nullable|string',
            'telegram' => 'bail|nullable|string|max:250',
            'instagram' => 'bail|nullable|string|max:250',
            'whatsapp' => 'bail|nullable|string|max:250',
            'youtube' => 'bail|nullable|string|max:250',
            'x' => 'bail|nullable|string|max:250',
            'ita' => 'bail|nullable|string|max:250',
            'igap' => 'bail|nullable|string|max:250',
            'aparat' => 'bail|nullable|string|max:250',
            'rubika' => 'bail|nullable|string|max:250',
            'soroush' => 'bail|nullable|string|max:250',
            'logo' => 'bail|nullable|string|max:250',
            'favicon' => 'bail|nullable|string|max:250',
        ];
    }
}
