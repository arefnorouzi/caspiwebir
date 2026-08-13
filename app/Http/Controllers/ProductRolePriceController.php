<?php

namespace App\Http\Controllers;

use App\Models\ProductRolePrice;
use App\Http\Requests\StoreProductRolePriceRequest;
use App\Http\Requests\UpdateProductRolePriceRequest;
use Illuminate\Support\Facades\Log;

class ProductRolePriceController extends Controller
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
    public function store(StoreProductRolePriceRequest $request)
    {
        try {
            $validated = $request->validated();
            $product_role_price = ProductRolePrice::where('product_id', $validated['product_id'])
                ->where('role_id', $validated['role_id'])->first();
            if ($product_role_price)
            {
                $product_role_price->price = $validated['price'];
                $product_role_price->offer_price = $validated['offer_price'];
                $product_role_price->update();
            }
            else{
                ProductRolePrice::create($validated);
            }
            return back()->with('message', 'قیمت ثبت شد');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت قیمت');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductRolePrice $productRolePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductRolePrice $productRolePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRolePriceRequest $request, ProductRolePrice $productRolePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductRolePrice $rolePrice)
    {
        $rolePrice->delete();
        return back()->with('message', 'رکورد حذف شد');
    }
}
