<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddInvoiceItemRequest extends FormRequest
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
            'product_id' => 'bail|nullable|integer|exists:products,id',
            'qty' => 'bail|required|integer|min:1',
            'unit_price' => 'bail|required|integer|min:0',
            'item_price' => 'bail|required|integer|min:0',
            'name' => 'bail|required|string|min:3|max:150',
            'invoice_item_status_id' => 'bail|required|integer|exists:invoice_item_statuses,id',

        ];
    }
}
