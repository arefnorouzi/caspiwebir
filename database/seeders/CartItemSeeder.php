<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = CartItem::first();
        if(!$model)
        {
            CartItem::factory()->count(50)->create();
        }
    }
}
