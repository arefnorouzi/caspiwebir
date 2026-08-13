<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        try {
            $model = new BlogCategory;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/BlogCategory/Index', [
            'models' => $models, 'search_text' => $request->search ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        $category_model = new BlogCategory;
        $categories = $category_model->select_categories();
        return Inertia::render('admin/BlogCategory/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            BlogCategory::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.blog-category.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.blog-category.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $category): \Inertia\Response
    {
        return Inertia::render('admin/BlogCategory/Edit', ['model' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $category): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $category->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.blog-category.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.category.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return back()->with('message', config('messages.deleted'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(BlogCategory $category): \Illuminate\Http\RedirectResponse
    {
        $category->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(BlogCategory $category): \Illuminate\Http\RedirectResponse
    {
        $category->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(BlogCategory $category): \Illuminate\Http\RedirectResponse
    {
        $category->status = !$category->status;
        $category->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
