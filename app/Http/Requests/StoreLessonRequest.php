<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'name' => 'bail|required|string|max:150',
            'lesson_time' => 'bail|nullable|string|max:150',
            'meta' => 'bail|nullable|string|max:250',
            'source' => 'bail|nullable|string|max:150',
            'image' => 'bail|nullable|string|max:150',
            'demo_link' => 'bail|nullable|string|max:150',
            'rank' => 'bail|nullable|integer|min:1|max:100',
            'status' => 'bail|nullable|boolean',
            'free' => 'bail|required|boolean',
            'course_id' => 'bail|required|integer|exists:courses,id',
            'user_id' => 'bail|nullable|integer|exists:users,id',
        ];
    }

    public function prepareForValidation(): void
    {
        if (!isset($this->user_id))
        {
            $this->merge([
                'user_id' => auth()->id(),
            ]);
        }
    }
}
