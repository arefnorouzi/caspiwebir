<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use Illuminate\Support\Facades\Log;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreProductVariantRequest $request)
    {
        try {
            $validated = $request->validated();
            $model = ProductVariant::create($validated);
            if ($validated['is_default'])
            {
                ProductVariant::where('product_id', $validated['product_id'])
                    ->where('id', '!=', $model->id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => config('messages.created')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, ProductVariant $variant)
    {
        try {
            $validated = $request->validated();
            $variant->update($validated);
            if ($validated['is_default'])
            {
                ProductVariant::where('product_id', $validated['product_id'])
                    ->where('id', '!=', $variant->id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => config('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }
}
