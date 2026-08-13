<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Course::first();
        if (! $model) {
            $products = Product::where('status', 1)->orderby('id', 'desc')->take(50)->get();
            foreach ($products as $product) {
                $items = [
                    ['name' => 'مقدمه', 'product_id' => $product->id, 'user_id' => 2],
                    ['name' => 'فصل اول: نصب و پیکربندی', 'product_id' => $product->id, 'user_id' => 2],
                    ['name' => 'فصل دوم: تکمیل پروژه', 'product_id' => $product->id, 'user_id' => 2],
                    ['name' => 'فصل سوم: پایانی', 'product_id' => $product->id, 'user_id' => 2],
                ];
                foreach ($items as $item) {
                    Course::create($item);
                }
            }

        }
    }
}
