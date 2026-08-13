<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = Comment::first();
        if(!$model)
        {
            $products = Product::active()->orderby('id', 'desc')->take(50)->get();
            foreach ($products as $product) {
                // 1-3 comments per product
                Comment::factory()
                    ->count(rand(1, 3))
                    ->forCommentable($product)
                    ->create();
            }

            $posts = Post::active()->orderby('id', 'desc')->take(20)->get();
            foreach ($posts as $post) {
                Comment::factory()
                    ->count(rand(1, 3))
                    ->forCommentable($post)
                    ->create();
            }
        }
    }
}
