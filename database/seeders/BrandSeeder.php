<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Brand::first();
        if (! $model) {

            $json_file = file_get_contents(public_path("db/brands.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                Brand::create([
                    'id' => $item['id'], 'name' => $item['name'], 'image' => $item['image'],
                    'slug' => $item['slug'], 'status' => 1
                ]);
            }

//            $items = [
//                ['id' => 1, 'name' => 'برنامه نویسی', 'slug' => 'programming', 'image' => '/images/brands/code.svg'],
//                ['id' => 2, 'name' => 'نرم افزار', 'slug' => 'software', 'image' => '/images/brands/software.svg'],
//                ['id' => 3, 'name' => 'سیستم عامل', 'slug' => 'os', 'image' => '/images/brands/os.svg'],
//                ['id' => 4, 'name' => 'دیجیتال مارکتینگ', 'slug' => 'digital-marketing', 'image' => '/images/brands/seo.svg'],
//                ['id' => 5, 'name' => 'شبکه', 'slug' => 'network', 'image' => '/icons/network.svg'],
//                ['id' => 6, 'name' => 'ارز دیجیتال', 'slug' => 'cryptocurrency', 'image' => '/images/brands/cryptocurrency.svg'],
//                ['id' => 7, 'name' => 'هوش مصنوعی', 'slug' => 'ai', 'image' => '/images/brands/ai.svg'],
//            ];
//
//            DB::table('brands')->insert($items);
        }
    }
}
