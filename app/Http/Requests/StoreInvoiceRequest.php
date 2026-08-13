<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'user_id' => 'bail|required|exists:users,id',
            'payment_method_id' => 'bail|required|exists:payment_methods,id',
            'shipping_method_id' => 'bail|required|exists:shipping_methods,id',
            'invoice_status_id' => 'bail|required|exists:invoice_statuses,id',
            'invoice_type_id' => 'bail|required|exists:invoice_types,id',
            'customer_note' => 'bail|nullable|string',
        ];
    }
}
