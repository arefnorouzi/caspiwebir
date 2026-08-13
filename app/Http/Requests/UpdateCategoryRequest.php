<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|min:2|max:100|unique:categories,name,' . $this->category->id,
            'parent_id' => 'bail|nullable|integer|min:1|max:10000|exists:categories,id',
            'image' => 'bail|nullable|string|min:15|max:250',
            'home_page' => 'bail|required|boolean',
            'status' => 'bail|required|boolean',
            'meta' => 'bail|nullable|string|max:250',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام دسته بندی',
            'parent_id' => 'دسته والد',
            'home_page' => 'نمایش در صفحه اصلی',
            'status' => 'وضعیت',
            'meta' => 'وضیحات متا',
        ];
    }
}
