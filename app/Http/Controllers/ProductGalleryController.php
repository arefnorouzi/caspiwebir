<?php

namespace App\Http\Controllers;

use App\Models\ProductGallery;
use App\Http\Requests\StoreProductGalleryRequest;
use App\Http\Requests\UpdateProductGalleryRequest;
use Illuminate\Support\Facades\Log;

class ProductGalleryController extends Controller
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
    public function store(StoreProductGalleryRequest $request)
    {
        try {
            $validated = $request->validated();
            ProductGallery::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => config('messages.created')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductGalleryRequest $request, ProductGallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $gallery): \Illuminate\Http\RedirectResponse
    {
        $gallery->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }
}
