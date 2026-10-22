<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:255|unique:products,name',
            'sku' => 'bail|nullable|string|min:1|max:70|unique:products,sku',
            'brand_id' => 'bail|nullable|integer|min:1|exists:brands,id',
            'price' => 'bail|required|integer|min:0',
            'offer_price' => 'bail|nullable|integer|min:0|lt:price',
            'offer_end_date' => 'bail|nullable|date|after:today',
            'stock' => 'bail|required|integer|min:0',
            'min_buy' => 'bail|required|integer|min:1|max:10000',
            'status' => 'bail|required|boolean',
            'downloadable' => 'bail|required|boolean',
            'is_service' => 'bail|required|boolean',
            'is_addon' => 'bail|required|boolean',
            'source' => 'bail|required|boolean',
            'course_time' => 'bail|nullable|string',
            'duration' => 'bail|nullable|integer|min:1',
            'pinned' => 'bail|required|boolean',
            'buyable' => 'bail|required|boolean',
            'installment_purchase' => 'bail|required|boolean',
            'suggested' => 'bail|required|boolean',
            'amazing' => 'bail|required|boolean',
            'pre_order' => 'bail|required|boolean',
            'call_to_price' => 'bail|required|boolean',
            'guarantee' => 'bail|nullable|string|min:2|max:250',
            'warranty' => 'bail|nullable|string|min:2|max:250',
            'meta' => 'bail|nullable|string|min:2|max:250',
            'description' => 'bail|nullable|string|min:10',
            'excerpt_review' => 'bail|nullable|string|min:10',
            'slug' => 'bail|required|string|min:3|max:255|unique:products,slug',
            'image' => 'bail|nullable|string|max:250',
            'video' => 'bail|nullable|string|max:250',
            'video_poster' => 'bail|nullable|string|max:250',
            'note' => 'bail|nullable|string|max:1000',
            'product_unit_id' => 'bail|required|integer|min:1|exists:product_units,id',
            'categories' => 'bail|required|array|min:1',
            'categories.*' => 'bail|required|integer|exists:categories,id',
        ];
    }



    protected function prepareForValidation(): void
    {
        if (!isset($this->sku)) {
            $this->merge([
                'sku' => time()
            ]);
        }
        elseif ($this->sku == '')
        {
            $this->sku = time();
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'عنوان الزامی است.',
            'categories.required' => 'حداقل یک دسته باید انتخاب شود.',
            'categories.*.exists' => 'دسته انتخابی معتبر نیست.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام محصول',
            'sku' => 'کد محصول',
            'slug' => 'لینک محصول',
            'product_unit_id' => 'واحد محصول',
            'categories' => 'دسته بندی',
            'image' => 'عکس محصول',
            'price' => 'قیمت محصول',
            'offer_price' => 'قیمت تخفیفی',
            'offer_end_date' => 'تاریخ انقضای تخفیف',
            'stock' => 'موجودی',
            'meta' => 'توضیحات متا',
            'description' => 'توضیحات محصول',
            'status' => 'وضعیت انتشار'
        ];
    }
}
