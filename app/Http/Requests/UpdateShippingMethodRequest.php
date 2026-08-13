<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingMethodRequest extends FormRequest
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
            'name' => 'bail|required|string|max:100',
            'code' => 'bail|required|string|max:100|unique:shipping_methods,code,' . $this->shipping->id,
            'base_cost' => 'bail|required|integer|min:0|max:100000000',
            'box_cost' => 'bail|required|integer|min:0|max:100000000',
            'description' => 'bail|nullable|string|max:250',
            'status' => 'bail|required|boolean',
            'is_default' => 'bail|required|boolean',
            'province_id' => 'bail|nullable|integer|exists:provinces,id',
            'city' => 'bail|nullable|string|max:150',
            'website' => 'bail|nullable|string|max:150',
            'image' => 'bail|nullable|string|max:200',

        ];
    }
}
