<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'product_id' => 'bail|required|integer|exists:products,id',
            'name' => 'bail|required|string|max:100',
            'meta' => 'bail|nullable|string|max:250',
            'source' => 'bail|nullable|string|max:250',
            'demo_link' => 'bail|nullable|string|max:250',
            'course_time' => 'bail|nullable|string|max:250',
            'image' => 'bail|nullable|string|max:250',
            'rank' => 'bail|nullable|integer|min:1|max:100',
            'status' => 'bail|required|boolean',
            'user_id' => 'bail|required|integer|exists:users,id',
        ];
    }
}
