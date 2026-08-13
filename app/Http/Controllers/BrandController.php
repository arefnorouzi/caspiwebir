<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Brand;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/brand/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/brand/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Brand::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.brand.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.brand.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): \Inertia\Response
    {
        return Inertia::render('admin/brand/Edit', ['model' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $brand->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.brand.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.brand.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): \Illuminate\Http\RedirectResponse
    {
        $brand->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(Brand $brand): \Illuminate\Http\RedirectResponse
    {
        $brand->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Brand $brand): \Illuminate\Http\RedirectResponse
    {
        $brand->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(Brand $brand): \Illuminate\Http\RedirectResponse
    {
        $brand->status = !$brand->status;
        $brand->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }

}
