<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = BlogCategory::first();
        if (! $model) {
            $json_file = file_get_contents(public_path("db/blog_categories.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item) {
                BlogCategory::create([
                    'id' => $item['id'], 'name' => $item['name'], 'image' => $item['image'],
                    'slug' => $item['slug'], 'status' => 1, 'parent_id' => $item['parent_id']
                ]);
            }
       }
//            $items = [
//                [
//                    'id' => 1, 'name' => 'برنامه نویسی', 'slug' => 'programming',
//                    'home_page' => true, 'status' => true, 'parent_id' => null,
//                ],
//                [
//                    'id' => 2, 'name' => 'وردپرس', 'slug' => 'wordpress',
//                    'home_page' => true, 'status' => true, 'parent_id' => null,
//                ],
//                [
//                    'id' => 3, 'name' => 'نرم افزار', 'slug' => 'software',
//                    'home_page' => true, 'status' => true, 'parent_id' => null,
//                ],
//                [
//                    'id' => 4, 'name' => 'شبکه', 'slug' => 'network',
//                    'home_page' => true, 'status' => true, 'parent_id' => null,
//                ],
//                [
//                    'id' => 5, 'name' => 'هوش مصنوعی', 'slug' => 'ai',
//                    'home_page' => true, 'status' => true, 'parent_id' => null,
//                ],
//            ];
//            DB::table('blog_categories')->insert($items);
       // }
    }
}
