<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:255|unique:posts',
            'status' => 'bail|required|boolean|',
            'meta' => 'bail|nullable|string|min:2|max:250',
            'description' => 'bail|nullable|string|min:10',
            'video' => 'bail|nullable|string|min:5',
            'slug' => 'bail|required|string|min:3|max:255|unique:posts',
            'image' => 'bail|nullable|string|max:250',
            'blog_category_id' => 'bail|required|integer|exists:blog_categories,id',
        ];
    }

//    protected function prepareForValidation(): void
//    {
//        $this->merge([
//            'slug' => Str::slug($this->name)
//        ]);
//    }

    public function messages(): array
    {
        return [
            'name.required' => 'عنوان الزامی است.',
            'blog_category_id.required' => 'یک دسته بندی باید انتخاب شود.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'عنوان مقاله',
            'slug' => 'لینک مقاله',
            'blog_category_id' => 'دسته بندی',
            'image' => 'عکس مقاله',
            'meta' => 'توضیحات متا',
            'description' => 'توضیحات مقاله',
            'status' => 'وضعیت انتشار',
            'pinned' => 'برگریده',
        ];
    }
}
