<?php

namespace App\Http\Controllers;

use App\Enums\ProductSliderType;
use App\Http\Requests\StoreProductSliderRequest;
use App\Http\Requests\UpdateProductSliderRequest;
use App\Models\ProductSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new ProductSlider;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/ProductSlider/Index', [
            'models' => $models, 'search_text' => $request->search ?? '']);
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
    public function store(StoreProductSliderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSlider $productSlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSlider $productSlider): \Inertia\Response
    {
        $slider_types = collect(ProductSliderType::cases())->map(fn ($t) => [
            'value' => $t->value,
            'label' => $t->label(),
        ]);

        return Inertia::render('admin/ProductSlider/Edit', [
            'model' => $productSlider, 'slider_types' => $slider_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSliderRequest $request, ProductSlider $productSlider): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $productSlider->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.product-slider.index')->withErrors($e->getMessage());
        }

        return to_route('admin.product-slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSlider $productSlider): \Illuminate\Http\RedirectResponse
    {
        $productSlider->delete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }

    public function restore(ProductSlider $productSlider): \Illuminate\Http\RedirectResponse
    {
        $productSlider->restore();
        Inertia::flash(['message' => config('messages.restored')]);

        return back();
    }

    public function toggle_status(ProductSlider $productSlider)
    {
        $productSlider->update(['status' => !$productSlider->status]);
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
