<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Post;
use App\Services\PregStr;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::where('status', true)->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->with(['category:id,name,slug'])
                ->paginate(12, [
                    'id', 'name', 'blog_category_id', 'slug', 'meta', 'user_id', 'image', 'published_at'
                ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $posts = [];
        }
        $categories = BlogCategory::where('status', true)
            ->withCount('posts')
            ->get(['id', 'name', 'slug', 'image']);
        return view('blog.index', ['posts' => $posts, 'categories' => $categories]);
    }

    public function blog_category(string $slug)
    {
        //validate slug
        $slug = PregStr::preg_slug($slug);
        try {
            $category = BlogCategory::where('slug', $slug)->where('status', true)->firstOrFail();

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect('/blog');
        }
        $category->load(['children']);
        $category_ids = $category->children->pluck('id')->toArray();
        $category_ids[] = $category->id;
        $posts = Post::where('status', true)->whereNotNull('published_at')
            ->whereIn('blog_category_id', $category_ids)
            ->with(['author:id,name'])
            ->paginate(10, ['id', 'name', 'blog_category_id', 'slug', 'meta', 'user_id', 'image', 'published_at']);
        $categories = BlogCategory::where('status', true)
            ->withCount('posts')
            ->get(['id', 'name', 'slug', 'image']);
        return view('blog.category', ['posts' => $posts, 'categories' => $categories, 'category_model' => $category]);
    }

    public function show(string $slug)
    {
        $slug = PregStr::preg_slug($slug);
        try {
            $post = Post::where('status', true)->whereNotNull('published_at')
                ->where('slug', $slug)
                ->with(['category:id,name,slug', 'author:id,name'])
                ->firstOrFail();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect('/blog');
        }
        if ($post->views < 1000000000)
        {
            $post->views += 1;
            $post->update();
        }
        $post->load(['category', 'author']);
        $post_model = new Post();
        $related_posts = $post_model->related_posts(blog_category_id: $post->blog_category_id);
        return view('blog.show', ['post' => $post, 'related_posts' => $related_posts]);
    }
}
