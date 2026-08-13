<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Post::first();
        if(!$model)
        {
            $json_file = file_get_contents(public_path("db/posts.json"));
            $data = json_decode($json_file, true);
            foreach ($data as $item)
            {
                Post::create($item);
//                Post::create([
//                    'id' => $item['id'], 'name' => $item['name'], 'image' => $item['image'],
//                    'slug' => $item['slug'], 'status' => $item['status'],
//                    'blog_category_id' => $item['blog_category_id'],
//                    'created_at' => $item['created_at'], 'updated_at' => $item['updated_at'],
//                    'published_at' => $item['published_at'], 'description' => $item['description'],
//                    'user_id' => $item['user_id'], 'views' => $item['views'], 'meta' => $item['meta']
//                ]);
            }
            //Post::factory()->count(34)->create();
        }
    }
}
