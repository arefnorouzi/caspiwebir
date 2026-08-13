<?php

namespace Database\Seeders;

use App\Models\ProductProperty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = ProductProperty::first();
        if (!$model) {

            $json_file = file_get_contents(public_path("db/product_properties.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item) {
                ProductProperty::create($item);
//                ProductProperty::create([
//                    'id' => $item['id'], 'property_name' => $item['property_name'],
//                    'property_value' => $item['property_value'],
//                    'pinned' => $item['pinned'], 'status' => 1, 'product_id' => $item['product_id']
//                ]);
            }
        }
    }
}
