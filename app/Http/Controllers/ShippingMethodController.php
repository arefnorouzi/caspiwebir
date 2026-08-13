<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShippingMethodRequest;
use App\Http\Requests\UpdateShippingMethodRequest;
use App\Models\Province;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $models = ShippingMethod::withTrashed()->get();
        $provinces = Province::get();

        return Inertia::render('admin/setting/Shipping', [
            'models' => $models, 'provinces' => $provinces,
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
    public function store(StoreShippingMethodRequest $request)
    {
        try {
            $validated = $request->validated();
            $model = ShippingMethod::create($validated);
            if ($model->is_default) {
                ShippingMethod::where('id', '!=', $model->id)->update(['is_default' => 0]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', config('messages.error'));
        }

        return back()->with('message', config('messages.created'));

    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingMethodRequest $request, ShippingMethod $shipping)
    {
        try {
            $validated = $request->validated();
            if ($validated['is_default']) {
                ShippingMethod::where('is_default', 1)->update(['is_default' => 0]);
            }
            $shipping->update($validated);
            $shipping->refresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', config('messages.error'));
        }

        return back()->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingMethod $shipping): \Illuminate\Http\RedirectResponse
    {
        if (! $shipping->is_default) {
            $shipping->delete();
            Inertia::flash(['message' => config('messages.deleted')]);
        }
        Inertia::flash(['message' => config('messages.default_access_denied')]);

        return back();
    }

    public function restore(ShippingMethod $shipping): \Illuminate\Http\RedirectResponse
    {
        $shipping->restore();
        Inertia::flash(['message' => config('messages.restored')]);

        return back();
    }

    public function toggle_status(ShippingMethod $shipping): \Illuminate\Http\RedirectResponse
    {
        if ($shipping->status)
        {
            $check_item = ShippingMethod::where('status', 1)->where('id', '!=', $shipping->id)->first();
            if (!$check_item)
            {
                return back()->with(['error' => 'وجود یک روش فعال اجباری است']);
            }
            if ($shipping->is_default)
            {
                return back()->with(['error' => 'نمیتوانید روش پیشفرض را غیرفعال کنید. لطفا ابتدا روش پیشفرض را تغییر دهید']);
            }
        }
        $shipping->status = !$shipping->status;
        $shipping->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
    public function toggle_default(ShippingMethod $shipping): \Illuminate\Http\RedirectResponse
    {
        if ($shipping->is_default){
            return back()->with(['error' => 'انتخاب یک روش پیشفرض اجباری است']);
        }
        $shipping->status = true;
        $shipping->is_default = true;
        $shipping->update();
        ShippingMethod::where('is_default', 1)->where('id', '!=', $shipping->id)
            ->update(['is_default' => 0]);

        return back()->with(['message' => 'روش پیشفرض تغییر کرد']);
    }
}
