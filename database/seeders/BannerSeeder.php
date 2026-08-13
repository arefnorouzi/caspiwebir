<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Banner::first();
        if (! $model) {
//            $items = [
//                ['id' => 1, 'name' => 'عطر مردانه', 'image' => '/images/banner/1-1.webp', 'link' => '/shop', 'rank' => 1, 'position' => 1, 'size' => 4],
//                ['id' => 2, 'name' => 'عطر زنانه', 'image' => '/images/banner/1-2.webp', 'link' => '/shop/category/accessories', 'rank' => 2, 'position' => 1, 'size' => 4],
//                ['id' => 3, 'name' => 'بادی اسلش', 'image' => '/images/banner/1-3.webp', 'link' => '/shop', 'rank' => 3, 'position' => 1, 'size' => 4],
//                ['id' => 4, 'name' => 'اسپری', 'image' => '/images/banner/1-4.webp', 'link' => '/shop', 'rank' => 4, 'position' => 1, 'size' => 4],
//            ];
//
//            DB::table('banners')->insert($items);

            $items = [
                ['name' => 'خرید قسطی', 'image' => '/images/banner/2-1.jpg', 'link' => '/pages/installment-payment', 'rank' => 1, 'position' => 2, 'size' => 2, 'page_section_id' => 3],
                ['name' => 'پرداخت با رمزارز', 'image' => '/images/banner/2-2.jpg', 'link' => '/pages/cryptocurrency-payment', 'rank' => 2, 'position' => 2, 'size' => 2, 'page_section_id' => 3],
            ];

            DB::table('banners')->insert($items);

//            $items = [
//                ['id' => 7, 'name' => 'خرید مانیتور', 'image' => '/images/banner/3-1.webp', 'link' => '/shop/category/monitor', 'rank' => 1, 'position' => 3, 'size' => 1],
//            ];
//
//            DB::table('banners')->insert($items);
        }
    }
}
