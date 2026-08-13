<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'customer_name' => 'bail|required|string|max:100',
            'customer_mobile' => 'bail|required|string|max:30',
            'customer_note' => 'bail|nullable|string|max:250',
            'payment_method_id' => 'bail|nullable|integer|exists:payment_methods,id',
            'shipping_method_id' => 'bail|nullable|integer|exists:shipping_methods,id',
            'invoice_status_id' => 'bail|required|integer|exists:invoice_statuses,id',
            'payment_status' => 'bail|required|boolean',
            'payable' => 'bail|required|boolean',
            'confirmed_by_user' => 'bail|required|boolean',
            'post_tracking_code' => 'bail|nullable|string',
        ];
    }
}
