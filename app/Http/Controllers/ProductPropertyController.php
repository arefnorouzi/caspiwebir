<?php

namespace App\Http\Controllers;

use App\Models\ProductProperty;
use App\Http\Requests\StoreProductPropertyRequest;
use App\Http\Requests\UpdateProductPropertyRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new ProductProperty;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/product-property/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductPropertyRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            ProductProperty::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', config('messages.error'));
        }
        return back()->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductProperty $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductProperty $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductPropertyRequest $request, ProductProperty $property): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $property->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', config('messages.error'));
        }
        return back()->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductProperty $property): \Illuminate\Http\RedirectResponse
    {
        $property->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_pin(ProductProperty $property): \Illuminate\Http\RedirectResponse
    {
        $property->pinned = !$property->pinned;
        $property->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }

    public function toggle_status(ProductProperty $property): \Illuminate\Http\RedirectResponse
    {
        $property->property_status = !$property->property_status;
        $property->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }
}
