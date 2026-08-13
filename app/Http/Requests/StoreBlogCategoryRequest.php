<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreBlogCategoryRequest extends FormRequest
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
            'name' => 'bail|required|string|min:2|max:100|unique:blog_categories,name',
            'slug' => 'bail|required|string|min:3|max:120|unique:blog_categories,slug',
            'parent_id' => 'bail|nullable|integer|min:1|max:10000|exists:blog_categories,id',
            'image' => 'bail|nullable|string|min:15|max:250',
            'home_page' => 'bail|required|boolean',
            'status' => 'bail|required|boolean',
            'meta' => 'bail|nullable|string|max:250',
        ];
    }

    public function prepareForValidation(): void
    {
        if (isset($this->name))
        {
            $this->merge([
                'slug' => Str::slug($this->name)
            ]);
        }
        else{
            $this->merge([
                'slug' => Str::slug(Str::random(10))
            ]);
        }

    }

    public function attributes()
    {
        return [
            'name' => 'نام دسته بندی',
            'slug' => 'لینک',
            'parent_id' => 'دسته والد',
            'home_page' => 'نمایش در صفحه اصلی',
            'status' => 'وضعیت',
            'meta' => 'توضیحات متا',
        ];
    }
}
