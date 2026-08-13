<?php

namespace Database\Seeders;

use App\Models\ShopSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = ShopSetting::first();
        if(!$model)
        {
            ShopSetting::create([
                'name' => 'فروشگاه ساز مارلیک',
                'phone' => '09192138510',
                'email' => 'info@caspiweb.ir',
                'address' => 'گیلان',
                'order_expire' => 168,
                'tax' => 10,
                'zip_code' => '1234567890',
                'mobile' => '09192138510',
                'stock_alert' => 0,
            ]);
        }
    }
}
