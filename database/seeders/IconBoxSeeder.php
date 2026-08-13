<?php

namespace Database\Seeders;

use App\Models\IconBox;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IconBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = IconBox::first();
        if (! $model) {
            $items = [
                ['name' => 'برنامه نویسی', 'image' => '/icons/code.svg', 'link' => '/', 'rank' => 1, 'position' => 1, 'size' => 3, 'page_section_id' => 1],
                ['name' => 'طراحی سایت', 'image' => '/icons/website.svg', 'link' => '/', 'rank' => 2, 'position' => 1, 'size' => 3, 'page_section_id' => 1],
                ['name' => 'دیجیتال مارکتینگ', 'image' => '/icons/seo.svg', 'link' => '/', 'rank' => 2, 'position' => 1, 'size' => 3, 'page_section_id' => 1],
                ['name' => 'وردپرس', 'image' => '/icons/wordpress.svg', 'link' => '/', 'rank' => 3, 'position' => 1, 'size' => 3, 'page_section_id' => 1],
                ['name' => 'دیتابیس', 'image' => '/icons/database.svg', 'link' => '/', 'rank' => 4, 'position' => 1, 'size' => 3, 'page_section_id' => 1],
                ['name' => 'لینوکس', 'image' => '/icons/linux.svg', 'link' => '/', 'rank' => 4, 'position' => 1, 'size' => 3, 'page_section_id' => 1],
            ];

            DB::table('icon_boxes')->insert($items);

            $items = [
                ['name' => 'پایتون', 'image' => '/icons/python.svg', 'link' => '/', 'rank' => 1, 'position' => 2, 'size' => 2, 'page_section_id' => 4],
                ['name' => 'پی اچ پی', 'image' => '/icons/php.svg', 'link' => '/', 'rank' => 2, 'position' => 2, 'size' => 2, 'page_section_id' => 4],
                ['name' => 'لاراول', 'image' => '/icons/laravel.svg', 'link' => '/', 'rank' => 3, 'position' => 2, 'size' => 2, 'page_section_id' => 4],
                ['name' => 'جنگو', 'image' => '/icons/dj.svg', 'link' => '/', 'rank' => 3, 'position' => 2, 'size' => 2, 'page_section_id' => 4],
                ['name' => 'ریکت', 'image' => '/icons/react.svg', 'link' => '/', 'rank' => 4, 'position' => 2, 'size' => 2, 'page_section_id' => 4],
                ['name' => 'ویو', 'image' => '/icons/vue.svg', 'link' => '/', 'rank' => 5, 'position' => 2, 'size' => 2, 'page_section_id' => 4],
            ];

            DB::table('icon_boxes')->insert($items);

            $items = [
                ['name' => 'هاست وردپرس', 'image' => '/icons/host.svg', 'link' => '/', 'rank' => 1, 'position' => 3, 'size' => 4, 'page_section_id' => 6],
                ['name' => 'ووکامرس', 'image' => '/images/woocommerce.png', 'link' => '/', 'rank' => 1, 'position' => 3, 'size' => 4, 'page_section_id' => 6],
                ['name' => 'المنتور', 'image' => '/images/elementor.png', 'link' => '/', 'rank' => 1, 'position' => 3, 'size' => 4, 'page_section_id' => 6],
                ['name' => 'پشتیبانی وردپرس', 'image' => '/icons/wordpress.svg', 'link' => '/', 'rank' => 1, 'position' => 3, 'size' => 4, 'page_section_id' => 6],
            ];

            DB::table('icon_boxes')->insert($items);
        }
    }
}
