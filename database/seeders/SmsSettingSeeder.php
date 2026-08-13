<?php

namespace Database\Seeders;

use App\Models\SmsSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = SmsSetting::first();
        if (!$model) {
            SmsSetting::create([
                'name' => 'کد تایید',
                'code' => 'verify_code',
                'pattern_id' => '414658',
                'status' => 1
            ]);

            SmsSetting::create([
                'name' => 'پیامک فاکتور',
                'code' => 'invoice',
                'pattern_id' => '414657',
                'status' => 1
            ]);
        }
    }
}
