<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'description' => 'bail|required|string|max:255',
            'support_reply' => 'bail|nullable|string|max:255',
            'status' => 'bail|required|boolean',
            'support_id' => 'bail|required|integer|exists:users,id',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'support_id' => auth()->id()
        ]);
    }


    public function attributes()
    {
        return [
            'description' => 'نظر کاربر',
            'support_reply' => 'پاسخ پشتیبان',
        ];
    }
}
