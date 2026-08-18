<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceStatusRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:255|unique:invoice_statuses,name',
            'status' => 'bail|required|boolean',
            'lifecycle' => 'bail|required|boolean',
            'code' => 'bail|required|string|min:2|max:30|unique:invoice_statuses,code',
            'image' => 'bail|nullable|string|max:200'
        ];
    }
}
