<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
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
            'code' => 'bail|required|string|max:50',
            'status' => 'bail|required|boolean',
            'is_default' => 'bail|required|boolean',
            'is_gateway' => 'bail|required|boolean',
            'description' => 'bail|nullable|string',
            'api_key' => 'bail|nullable|string|max:255',
            'terminal_id' => 'bail|nullable|string|max:255',
            'merchant' => 'bail|nullable|string|max:255',
            'username' => 'bail|nullable|string|max:255',
            'password' => 'bail|nullable|string|max:255',
            'image' => 'bail|nullable|string|max:255',
            'note' => 'bail|nullable|string|max:255',
        ];
    }
}
