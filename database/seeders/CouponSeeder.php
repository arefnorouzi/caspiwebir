<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Coupon::first();
        if (!$model){
            Coupon::create([
                'name' => 'تابستان 1405',
                'code' => 'summer405',
                'coupon_type' => 'percent',
                'value' => 30,
                'min_purchase' => 20000,
                'expires_at' => now()->addDays(110),
            ]);

            Coupon::create([
                'name' => 'خرید بالای 1 میلیون',
                'code' => 'off1',
                'coupon_type' => 'percent',
                'value' => 20,
                'min_purchase' => 1000000
            ]);

            Coupon::create([
                'name' => 'خرید بالای 2 میلیون',
                'code' => 'off2',
                'coupon_type' => 'percent',
                'value' => 25,
                'min_purchase' => 2000000
            ]);

        }
    }
}
