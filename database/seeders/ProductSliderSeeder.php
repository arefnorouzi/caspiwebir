<?php

namespace Database\Seeders;

use App\Models\ProductSlider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = ProductSlider::first();
        if (! $model) {
            $items = [
                ['id' => 1, 'name' => 'تخفیف تایم', 'slug' => 'limitted_offer', 'rank' => 1, 'position' => 1, 'page_section_id' => 2],
                ['id' => 2, 'name' => 'شگفت انگیزها', 'slug' => 'amazing', 'rank' => 2, 'position' => 1, 'page_section_id' => 2],
                ['id' => 3, 'name' => 'محصولات پیشنهادی', 'slug' => 'suggested', 'rank' => 1, 'position' => 2, 'page_section_id' => 2],
                ['id' => 4, 'name' => 'فروش ویژه', 'slug' => 'featured', 'rank' => 2, 'position' => 2, 'page_section_id' => 2],
                ['id' => 5, 'name' => 'جدیدترین محصولات', 'slug' => 'latest', 'rank' => 1, 'position' => 3, 'page_section_id' => 5],
                ['id' => 6, 'name' => 'محبوب‌ترین محصولات', 'slug' => 'popular', 'rank' => 2, 'position' => 3, 'page_section_id' => 5],
                ['id' => 7, 'name' => 'پرفروش‌ترین‌ها', 'slug' => 'best_seller', 'rank' => 3, 'position' => 3, 'page_section_id' => 5],
            ];

            DB::table('product_sliders')->insert($items);
        }
    }
}
