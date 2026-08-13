<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductSizeRequest extends FormRequest
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
            'product_weight' => 'bail|nullable|integer|min:0',
            'product_lenght' => 'bail|nullable|integer|min:0',
            'product_width' => 'bail|nullable|integer|min:0',
            'product_height' => 'bail|nullable|integer|min:0',
            'need_box' => 'bail|required|boolean',
            'huge_box' => 'bail|required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'product_weight' => 'وزن کالا',
            'product_lenght' => 'طول کالا',
            'product_width' => 'عرض کالا',
            'product_height' => 'ارتفاع کالا',
            'need_box' => 'نیاز به بسته بندی',
            'huge_box' => 'کالای حجیم',
        ];
    }
}
