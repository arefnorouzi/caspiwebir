<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'title' => 'bail|required|string|min:3|max:150',
            'description' => 'bail|required|string|min:3|max:250',
            'secret_message' => 'bail|nullable|string|min:1|max:50',
            'department_id' => 'bail|required|integer|exists:departments,id',
            'level' => 'bail|required|integer|min:1|max:4',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان',
            'description' => 'متن پیام',
            'secret_message' => 'پیام محرمانه',
            'department_id' => 'دپارتمان',
            'level' => 'اولویت درخواست',
        ];
    }
}
