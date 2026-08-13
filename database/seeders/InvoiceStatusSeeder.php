<?php

namespace Database\Seeders;

use App\Models\InvoiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = InvoiceStatus::first();
        if (is_null($items)) {
            $items = [
                ['id' => 1, 'name' => 'پیش فاکتور', 'code' => 'pending', 'css_class' => 'text-amber-800'],
                ['id' => 2, 'name' => 'پرداخت شده', 'code' => 'paid', 'css_class' => 'text-green-800'],
                ['id' => 3, 'name' => 'در انتظار تایید امور مالی', 'code' => 'finance_pending', 'css_class' => 'text-amber-800'],
                ['id' => 4, 'name' => 'تایید امور مالی', 'code' => 'finance_confirmed', 'css_class' => 'text-amber-800'],
                ['id' => 5, 'name' => 'آماده سازی برای ارسال', 'code' => 'processed', 'css_class' => 'text-green-800'],
                ['id' => 6, 'name' => 'ارسال شده', 'code' => 'shipped', 'css_class' => 'text-green-800'],
                ['id' => 7, 'name' => 'تکمیل شده', 'code' => 'completed', 'css_class' => 'text-green-800'],
                ['id' => 8, 'name' => 'منقضی شده', 'code' => 'expired', 'css_class' => 'text-red-800'],
                ['id' => 9, 'name' => 'لغو شده', 'code' => 'cancelled', 'css_class' => 'text-amber-800'],
            ];

            DB::table('invoice_statuses')->insert($items);
        }
    }
}
