<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = TicketStatus::first();
        if (is_null($items)) {
            $items = [
                ['id' => 1, 'name' => 'جدید', 'code' => 'open', 'css_class' => 'text-amber-900'],
                ['id' => 2, 'name' => 'پاسخ پشتیبان', 'code' => 'answered', 'css_class' => 'text-green-900'],
                ['id' => 3, 'name' => 'درحال بررسی', 'code' => 'review', 'css_class' => 'text-rose-700'],
                ['id' => 4, 'name' => 'پاسخ کاربر', 'code' => 'reopen', 'css_class' => 'text-amber-900'],
                ['id' => 5, 'name' => 'بسته شده', 'code' => 'closed', 'css_class' => 'text-black'],
            ];

            DB::table('ticket_statuses')->insert($items);
        }
    }
}
