<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        try {
            $model = new Category;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/category/Index', [
            'models' => $models, 'search_text' => $request->search ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        try {
            $model = new Category;
            $categories = $model->select_categories();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $categories = [];
        }
        return Inertia::render('admin/category/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Category::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.category.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.category.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): \Inertia\Response
    {
        try {
            $model = new Category;
            $categories = $model->select_categories();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $categories = [];
        }
        return Inertia::render('admin/category/Edit', ['model' => $category, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $category->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.category.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.category.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->delete();
        return back()->with('message', config('messages.deleted'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->status = !$category->status;
        $category->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }
}
