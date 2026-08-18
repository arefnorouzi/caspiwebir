<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Menu::first();
        if (! $model) {
            $header_menu = [
                ['id' => 1, 'name' => 'خانه', 'slug' => '/', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 2, 'name' => 'محصولات', 'slug' => '/shop', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 3, 'name' => 'آموزش ها', 'slug' => '/shop/courses', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 4, 'name' => 'خدمات', 'slug' => '/shop/services', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 5, 'name' => 'وبلاگ', 'slug' => '/blog', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 6, 'name' => 'فروش ویژه', 'slug' => '/shop/featured', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 7, 'name' => 'حساب کاربری', 'slug' => '/dashboard', 'status' => true, 'parent_id' => null, 'position' => 'main_menu'],
                ['id' => 8, 'name' => 'ورود / ثبت نام', 'slug' => '/login', 'status' => true, 'parent_id' => 5, 'position' => 'main_menu'],
                ['id' => 9, 'name' => 'سبد خرید', 'slug' => '/cart', 'status' => true, 'parent_id' => 5, 'position' => 'main_menu'],
                ['id' => 10, 'name' => 'تسویه حساب', 'slug' => '/checkout', 'status' => true, 'parent_id' => 5, 'position' => 'main_menu'],
                ['id' => 11, 'name' => 'سفارشات اخیر', 'slug' => '/dashboard/invoice', 'status' => true, 'parent_id' => 5, 'position' => 'main_menu'],
                ['id' => 12, 'name' => 'حساب کاربری', 'slug' => '/dashboard', 'status' => true, 'parent_id' => 5, 'position' => 'main_menu'],
            ];
            DB::table('menus')->insert($header_menu);

            $footer_menu = [
                ['id' => 13, 'name' => 'خانه', 'slug' => '/', 'status' => true, 'parent_id' => null, 'position' => 'footer_menu'],
                ['id' => 14, 'name' => 'قوانین', 'slug' => '/terms', 'status' => true, 'parent_id' => null, 'position' => 'footer_menu'],
                ['id' => 15, 'name' => 'پیگیری سفارش', 'slug' => '/dashboard/invoice', 'status' => true, 'parent_id' => null, 'position' => 'footer_menu'],
                ['id' => 16, 'name' => 'تماس با ما', 'slug' => '/contact', 'status' => true, 'parent_id' => null, 'position' => 'footer_menu'],
                ['id' => 17, 'name' => 'درباره ما', 'slug' => '/about', 'status' => true, 'parent_id' => null, 'position' => 'footer_menu'],
            ];

            DB::table('menus')->insert($footer_menu);

        }
    }
}
