<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Slider::first();
        if (!$model)
        {
            $items = [
                ['id' => 1, 'name' => 'آموزش برنامه نویسی و طراحی سایت', 'image' => '/images/slider/1.jpg', 'status' => true, 'mobile' => false],
                ['id' => 2, 'name' => 'طراحی فروشگاه اینترنتی و سئو سایت', 'image' => '/images/slider/2.jpg', 'status' => true, 'mobile' => false],
                ['id' => 3, 'name' => 'خدمات میزبانی وب و خرید دامنه', 'image' => '/images/slider/3.jpg', 'status' => true, 'mobile' => false],
            ];

            DB::table('sliders')->insert($items);
        }
    }
}
