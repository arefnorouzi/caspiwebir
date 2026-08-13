<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = ShippingMethod::first();
        if(!$model)
        {
            $items = [
                ['id' => 1, 'name' => 'دانلود', 'code' => 'download', 'base_cost' => 0, 'description' => 'دانلود مستقیم', 'is_default' => true],
                ['id' => 2, 'name' => 'ایمیل', 'code' => 'email', 'base_cost' => 0, 'description' => 'ارسال ایمیل', 'is_default' => false],
                ['id' => 3, 'name' => 'پیام رسان', 'code' => 'messenger', 'base_cost' => 0, 'description' => 'ارسال در پیام رسان', 'is_default' => false],
            ];

            DB::table('shipping_methods')->insert($items);
        }

    }
}
