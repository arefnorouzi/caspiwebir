<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Category::first();
        if (!$model) {

            $json_file = file_get_contents(public_path("db/categories.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                Category::create([
                    'id' => $item['id'], 'name' => $item['name'], 'image' => $item['image'],
                    'slug' => $item['slug'], 'status' => 1, 'parent_id' => $item['parent_id']
                ]);
            }
//            $items = [
//                ['id' => 1, 'name' => 'برنامه نویسی', 'slug' => 'programming', 'image' => '/icons/code.svg', 'parent_id' => null, 'home_page' => false],
//                ['id' => 2, 'name' => 'دیجیتال مارکتینگ', 'slug' => 'digital-marketing', 'image' => '/icons/seo.svg', 'parent_id' => null, 'home_page' => false],
//                ['id' => 3, 'name' => 'وردپرس', 'slug' => 'wordfpress', 'image' => '/icons/wordpress.svg', 'parent_id' => null, 'home_page' => false],
//                ['id' => 4, 'name' => 'برنامه نویسی وب', 'slug' => 'web-development', 'image' => '/icons/website.svg', 'parent_id' => 1, 'home_page' => false],
//                ['id' => 5, 'name' => 'برنامه نویسی موبایل', 'slug' => 'mobile-programming', 'image' => '/icons/mobile-app.svg', 'parent_id' => 1, 'home_page' => false],
//                ['id' => 6, 'name' => 'برنامه نویسی ویندوز', 'slug' => 'windows-programming', 'image' => '/icons/windows.svg', 'parent_id' => 1, 'home_page' => false],
//                ['id' => 7, 'name' => 'مهارت های ICDL', 'slug' => 'icdl', 'image' => '/icons/word.svg', 'parent_id' => null, 'home_page' => false],
//                ['id' => 8, 'name' => 'ارز دیجیتال', 'slug' => 'cryptocurrency', 'image' => '/icons/cryptocurrency.svg', 'parent_id' => null, 'home_page' => false],
//                ['id' => 9, 'name' => 'هوش مصنوعی', 'slug' => 'ai', 'image' => '/icons/ai.svg', 'parent_id' => null, 'home_page' => false],
//
//            ];
//
//            DB::table('categories')->insert($items);
        }
    }
}
