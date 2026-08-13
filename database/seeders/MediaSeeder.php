<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Media::first();
        if(!$model)
        {
            $json_file = file_get_contents(public_path("db/media.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                Media::create($item);
            }
            // icons
//            $icons = ['apple', 'android', 'windows', 'support', 'cashback', 'teacher', 'telegram',
//                'instagram', 'youtube', 'whatsapp', 'linux', 'python', 'php', 'laravel'];
//            foreach ($icons as $icon){
//                Media::create([
//                    'name' => $icon,
//                    'media_path' => '/icons/' . $icon . '.svg',
//                    'thumbnail' => '/icons/' . $icon . '.svg',
//                    'file_name' => $icon . '.svg',
//                    'media_extension' => 'svg',
//                    'media_type' => 'image'
//                ]);
//            }
//            $products = Product::get(['id', 'image', 'name']);
//            foreach ($products as $product){
//                $img = str_replace('/images/products/', '', $product->image);
//                Media::create([
//                    'name' => $product->name,
//                    'media_path' => $product->image,
//                    'thumbnail' => $product->image,
//                    'file_name' => $img,
//                    'media_extension' => substr($img, -4),
//                    'media_type' => 'image'
//                ]);
//            }
        }
    }
}
