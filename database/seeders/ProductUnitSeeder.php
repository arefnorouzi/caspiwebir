<?php

namespace Database\Seeders;

use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ProductUnit::first();
        if(!$items)
        {
            $items = [
                ['id' => 1, 'name' => 'عدد', 'status' => true, 'is_default' => true],
                ['id' => 2, 'name' => 'دستگاه', 'status' => true, 'is_default' => false],
                ['id' => 3, 'name' => 'بلوک', 'status' => true, 'is_default' => false],
                ['id' => 4, 'name' => 'جفت', 'status' => true, 'is_default' => false],
                ['id' => 5, 'name' => 'دست', 'status' => true, 'is_default' => false],
                ['id' => 6, 'name' => 'متر', 'status' => true, 'is_default' => false],
                ['id' => 7, 'name' => 'جین', 'status' => true, 'is_default' => false],
                ['id' => 8, 'name' => 'شاخه', 'status' => true, 'is_default' => false],
                ['id' => 9, 'name' => 'حلقه', 'status' => true, 'is_default' => false],
                ['id' => 10, 'name' => 'جعبه', 'status' => true, 'is_default' => false],
                ['id' => 11, 'name' => 'پاکت', 'status' => true, 'is_default' => false],
                ['id' => 12, 'name' => 'گرم', 'status' => true, 'is_default' => false],
                ['id' => 13, 'name' => 'کیلو', 'status' => true, 'is_default' => false],
            ];

            DB::table('product_units')->insert($items);
        }
    }
}
