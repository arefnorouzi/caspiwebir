<?php

namespace Database\Seeders;

use App\Models\InvoiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = InvoiceType::first();
        if (is_null($items)) {
            $items = [
                ['id' => 1, 'name' => 'خرید', 'code' => 'buy', 'css_class' => 'text-green-800', 'interest_rate' => 0],
                ['id' => 2, 'name' => 'برداشت', 'code' => 'withdraw', 'css_class' => 'text-red-600', 'interest_rate' => 0],
            ];

            DB::table('invoice_types')->insert($items);
        }
    }
}
