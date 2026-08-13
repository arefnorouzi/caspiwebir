<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Coupon;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/coupon/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/coupon/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Coupon::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.coupon.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }

        return to_route('admin.coupon.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon): \Inertia\Response
    {
        return Inertia::render('admin/coupon/Edit', ['model' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $coupon->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.coupon.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }

        return to_route('admin.coupon.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon): \Illuminate\Http\RedirectResponse
    {
        $coupon->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(Coupon $coupon): \Illuminate\Http\RedirectResponse
    {
        $coupon->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Coupon $coupon): \Illuminate\Http\RedirectResponse
    {
        $coupon->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(Coupon $coupon): \Illuminate\Http\RedirectResponse
    {
        $coupon->active = !$coupon->active;
        $coupon->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
