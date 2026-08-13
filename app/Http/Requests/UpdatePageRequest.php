<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:255|unique:pages,name,' . $this->page->id,
            'status' => 'bail|required|boolean',
            'meta' => 'bail|nullable|string|min:2|max:250',
            'description' => 'bail|nullable|string|min:10',
            'slug' => 'bail|required|string|min:3|max:255|unique:pages,slug,' . $this->page->id,
            'image' => 'bail|nullable|string|max:250',
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
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'عنوان صفحه',
            'slug' => 'لینک صفحه',
            'image' => 'عکس صفحه',
            'meta' => 'توضیحات متا',
            'description' => 'توضیحات صفحه',
            'status' => 'وضعیت انتشار',
        ];
    }
}
