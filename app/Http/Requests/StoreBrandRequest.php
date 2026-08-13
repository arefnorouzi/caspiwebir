<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreBrandRequest extends FormRequest
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
            'name' => 'bail|required|string|min:2|max:100|unique:brands,name',
            'slug' => 'bail|required|string|min:3|max:120|unique:brands,slug',
            'website' => 'bail|nullable|url|min:10|max:100',
            'image' => 'bail|nullable|string|min:15|max:250',
            'status' => 'bail|required|boolean'
        ];
    }

    public function prepareForValidation(): void
    {
        if (isset($this->name))
        {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }
        else{
            $this->merge([
                'slug' => 'brand-' . Str::uuid(),
            ]);
        }
        if (!isset($this->status)){
            $this->merge(['status' => 0]);
        }

    }

    public function attributes()
    {
        return [
            'name' => 'نام برند',
            'slug' => 'نامک برند',
            'website' => 'وبسایت',
            'image' => 'عکس برند',
        ];
    }
}
