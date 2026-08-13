<?php

namespace App\Http\Controllers;

use App\Models\InventoryProduct;
use App\Http\Requests\StoreInventoryProductRequest;
use App\Http\Requests\UpdateInventoryProductRequest;
use Illuminate\Support\Facades\Log;

class InventoryProductController extends Controller
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
    public function store(StoreInventoryProductRequest $request)
    {
        $validated = $request->validated();
        try {
            $model = InventoryProduct::where('product_id', $validated['product_id'])
                ->where('inventory_id', $validated['inventory_id'])
                ->first();
            if ($model)
            {
                $model->qty = $validated['qty'];
                $model->update();
            }
            else{
                InventoryProduct::create([
                    'product_id' => $validated['product_id'],
                    'inventory_id' => $validated['inventory_id'],
                    'qty' => $validated['qty'],
                ]);
            }

            return back()->with('message', 'موجودی انبار بروز شد');

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'اطلاعات فرم نامعتبر است');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryProduct $inventoryProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryProduct $inventoryProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryProductRequest $request, InventoryProduct $inventoryProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryProduct $inventoryProduct)
    {
        //
    }
}
