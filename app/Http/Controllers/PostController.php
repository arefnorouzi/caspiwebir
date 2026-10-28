<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Post;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        $category_model = new BlogCategory;
        $categories = $category_model->select_categories();

        return Inertia::render('admin/post/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        $category_model = new BlogCategory;
        $categories = $category_model->select_categories();

        return Inertia::render('admin/post/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            if (isset($validated['image']) && strlen($validated['image']) > 0 && $validated['status']) {
                $validated['published_at'] = now();
            }
            Post::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.post.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.post.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): \Inertia\Response
    {
        $post->load(['category:id,name,slug', 'author:id,name:mobile']);

        return Inertia::render('admin/post/Show', ['model' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): \Inertia\Response
    {
        $post->load(['category:id,name,slug', 'author:id,name:mobile']);
        $category_model = new BlogCategory;
        $categories = $category_model->select_categories();

        return Inertia::render('admin/post/Edit', [
            'model' => $post, 'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            if ($post->status && is_null($post->published_at)) {
                $post->published_at = now();
            }
            $post->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.post.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.post.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(Post $post)
    {
        if ($post->image && is_null($post->published_at))
        {
            $post->published_at = now();
        }
        $post->status = !$post->status;
        $post->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }

}
