<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRelatedRequest;
use App\Models\ProductRelated;
use Illuminate\Support\Facades\Log;

class ProductRelatedController extends Controller
{
    public function store(ProductRelatedRequest $request)
    {
        try {
            $validated = $request->validated();
            ProductRelated::firstOrCreate(
                ['product_id' => $validated['product_id'], 'related_product_id' => $validated['related_product_id']],
            );
            return back()->with('message', 'اطلاعات با موفقیت ثبت شد');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت اطلاعات');
        }
    }

    public function destroy($id)
    {
        ProductRelated::where('id', $id)->delete();
        return back()->with('message', 'رکود حذف شد');
    }
}
