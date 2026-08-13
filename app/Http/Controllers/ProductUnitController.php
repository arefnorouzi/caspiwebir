<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use App\Http\Requests\StoreProductUnitRequest;
use App\Http\Requests\UpdateProductUnitRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new ProductUnit();
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/unit/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/unit/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductUnitRequest $request)
    {
        $validated = $request->validated();
        try {
            $model = ProductUnit::create($validated);
            if ($validated['is_default'])
            {
                ProductUnit::where('is_default', 1)->where('id', '!=', $model->id)
                    ->update(['is_default' => 0]);
            }
            Inertia::flash(['message' => config('messages.created')]);

        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);
            return to_route('admin.unit.index')->withErrors($e->getMessage());
        }

        return to_route('admin.unit.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductUnit $unit)
    {
        return Inertia::render('admin/unit/Edit', ['model' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductUnitRequest $request, ProductUnit $unit)
    {
        try {
            $validated = $request->validated();
            $unit->update($validated);
            if ($validated['is_default'])
            {
                ProductUnit::where('is_default', 1)->where('id', '!=', $unit->id)
                    ->update(['is_default' => 0]);
            }
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.brand.index')->withErrors($e->getMessage());
        }

        return to_route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductUnit $unit): \Illuminate\Http\RedirectResponse
    {
        $unit->delete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }

    public function restore(ProductUnit $unit): \Illuminate\Http\RedirectResponse
    {
        $unit->restore();
        Inertia::flash(['message' => config('messages.restored')]);

        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(ProductUnit $unit): \Illuminate\Http\RedirectResponse
    {
        $unit->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }
}
