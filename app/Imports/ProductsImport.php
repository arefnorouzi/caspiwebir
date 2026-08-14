<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRolePrice;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError
{
    public function onError(\Throwable $e)
    {
        Log::error($e->getMessage());
    }
    public function onRow(Row $row)
    {
        $data = $row->toArray();
        $product = Product::find($data['id']);

        if (!$product) {
            throw new \Exception("Product ID {$data['id']} not found");
        }
        if (isset($data['offer_price']))
        {
            $data['offer_price'] = trim($data['offer_price']);
            $data['offer_price'] = intval($data['offer_price']);
        }
        else{
            $data['offer_price'] = $product->offer_price;
        }
        if (isset($data['price']) && $data['price'] >= 0)
        {
            $data['price'] = trim($data['price']);
            $data['price'] = intval($data['price']);
        }
        else{
            $data['price'] = $product->price;
        }
        if (isset($data['stock']))
        {
            $data['stock'] = trim($data['stock']);
            $data['stock'] = intval($data['stock']);
        }
        if (isset($data['rank']))
        {
            $data['rank'] = trim($data['rank']);
            $data['rank'] = intval($data['rank']);
        }
        if (isset($data['publish']) && $data['publish'])
        {
            $data['publish'] = 1;
        }
        else{
            $data['publish'] = 0;
        }
        if (isset($data['feature']) && $data['feature'])
        {
            $data['feature'] = 1;
        }
        else{
            $data['feature'] = 0;
        }

        if (isset($data['installment_purchase']) && $data['installment_purchase'])
        {
            $data['installment_purchase'] = 1;
        }
        else{
            $data['torobpay'] = 0;
        }
        if (isset($data['buyable']) && $data['buyable'])
        {
            $data['buyable'] = 1;
        }
        else{
            $data['buyable'] = 0;
        }
        if (isset($data['pre_order']) && $data['pre_order'])
        {
            $data['pre_order'] = 1;
        }
        else{
            $data['pre_order'] = 0;
        }
        if (isset($data['amazing']) && $data['amazing'])
        {
            $data['amazing'] = 1;
        }
        else{
            $data['amazing'] = 0;
        }
        if (isset($data['suggested']) && $data['suggested'])
        {
            $data['suggested'] = 1;
        }
        else{
            $data['suggested'] = 0;
        }
        if (isset($data['downloadable']) && $data['downloadable'])
        {
            $data['downloadable'] = 1;
        }
        else{
            $data['downloadable'] = 0;
        }
        // آپدیت فیلدهای محصول
        $data['brand'] = trim($data['brand']);
        if ($data['brand'] != $product?->brand?->name)
        {
            $brand = Brand::where('name', trim($data['brand']))->first();
            if ($brand)
            {
                $product->brand_id = $brand->id;
            }
            else{
                $product->brand_id = null;
            }
        }


        $product->name = $data['name'] ?? $product->name;
        $product->sku = $data['code'] ?? $product->sku;
        $product->stock = $data['stock'];
        $product->rank = $data['rank'];
        $product->price = $data['price'];
        $product->offer_price = $data['offer_price'];
        $product->status = $data['publish'];
        $product->pinned = $data['feature'];
        $product->installment_purchase = $data['installment_purchase'];
        $product->buyable = $data['buyable'];
        $product->pre_order = $data['pre_order'];
        $product->suggested = $data['suggested'];
        $product->amazing = $data['amazing'];
        $product->downloadable = $data['downloadable'];
        $product->update();
        if (isset($data['categories']) && $data['categories'])
        {
            $categoryIds = explode('|', $data['categories']);
            $product->categories()->sync(
                Category::whereIn('id', $categoryIds)->pluck('id')->toArray()
            );
        }

    }

    public function rules(): array
    {
        return [
            'id'        => 'required|integer|exists:products,id',
            'code'       => 'required',
            'brand'       => 'nullable',
            'categories'       => 'nullable',
            'rank'       => 'required',
            'stock'       => 'required',
            'price'    => 'required',
            'offer_price'  => 'nullable',
            'offer_end_date'  => 'nullable',
            'publish'       => 'required',
            'feature'         => 'required',
            'installment_purchase'         => 'required',
            'buyable'         => 'required',
            'pre_order'         => 'required',
            'amazing'         => 'required',
            'suggested'         => 'required',
            'downloadable'         => 'required',
        ];
    }
}
