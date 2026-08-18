<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithHeadings, WithMapping
{
    protected array $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Product::query()
            ->whereNotNull('image')
            ->orderby('id','desc')
            ->orderBy('views','desc')
            ->with(['brand:id,name', 'role_prices', 'categories:id,name'])
            ->select('id','name', 'brand_id', 'sku', 'rank', 'stock', 'price', 'offer_price', 'offer_end_date', 'status', 'pinned', 'installment_purchase', 'buyable', 'pre_order', 'amazing', 'suggested', 'downloadable', 'is_service', 'is_addon');
        if (isset($this->filters['categories']) && count($this->filters['categories']))
        {
            $category_ids = $this->filters['categories'];
            $query->whereHas('categories', function ($q) use ($category_ids) {
                $q->whereIn('categories.id', $category_ids);
            });
        }


        if (isset($this->filters['brand_id'])) {
            $query->where('brand_id', $this->filters['brand_id']);
        }
        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (isset($this->filters['pinned'])) {
            $query->where('pinned', $this->filters['pinned']);
        }

        return $query;

    }

    public function map($product): array
    {
        $categories = '';
        if (isset($product->categories)) {
            $categories = $product->categories->pluck('id')->implode('|');
        }
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product?->brand?->name ?? '',
            $categories,
            $product->rank > 0 ? "$product->rank" : "1000",
            $product->stock > 0 ? "$product->stock" : "0",
            $product->price > 0 ? "$product->price" : "0",
            $product->offer_price ?? null,
            $product->offer_end_date ?? null,
            $product->status ? "1" : "0",
            $product->pinned ? "1" : "0",
            $product->installment_purchase ? "1" : "0",
            $product->buyable ? "1" : "0",
            $product->pre_order ? "1" : "0",
            $product->amazing ? "1" : "0",
            $product->suggested ? "1" : "0",
            $product->downloadable ? "1" : "0",
            $product->is_service ? "1" : "0",
            $product->is_addon ? "1" : "0",
            $product->sales > 0 ? "$product->sales" : "0",
        ];
    }

    public function headings(): array
    {
        return ['id', 'name', 'code', 'brand', 'categories', 'rank', 'stock', 'price', 'offer_price', 'offer_end_date', 'publish', 'feature', 'installment_purchase', 'buyable', 'pre_order', 'amazing', 'suggested', 'downloadable', 'is_service', 'is_addon', 'sales'];
    }
}
