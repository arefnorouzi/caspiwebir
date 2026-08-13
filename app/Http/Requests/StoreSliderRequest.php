<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check()) {
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
            'url' => 'bail|nullable|string|max:150',
            'image' => 'bail|required|string|max:250',
            'status' => 'bail|required|boolean',
            'mobile' => 'bail|required|boolean',
            'rank' => 'bail|required|integer|min:1|max:250',
        ];
    }

    public function prepareForValidation(): void
    {
        if (!isset($this->rank)){
            $this->merge(['rank' => 10]);
        }
        if (!isset($this->mobile)){
            $this->merge(['mobile' => 0]);
        }

    }

}
