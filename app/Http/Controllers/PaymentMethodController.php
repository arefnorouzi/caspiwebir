<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new PaymentMethod;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/PaymentMethod/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/PaymentMethod/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request)
    {
        try {
            $validated = $request->validated();
            PaymentMethod::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.payment.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }

        return to_route('admin.payment.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $payment): \Inertia\Response
    {
        return Inertia::render('admin/PaymentMethod/Edit', ['model' => $payment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            if ($validated['is_default']) {
                PaymentMethod::where('is_default', 1)->update(['is_default' => 0]);
            }
            $payment->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }

        return back()
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $payment): \Illuminate\Http\RedirectResponse
    {
        if (! $payment->is_default) {
            $payment->delete();
            return back()->with(['message' => config('messages.deleted')]);
        }
        return back()->with(['error' => config('messages.default_access_denied')]);
    }

    public function restore(PaymentMethod $payment): \Illuminate\Http\RedirectResponse
    {
        $payment->restore();
        return back()->with(['message' => config('messages.restored')]);
    }

    public function toggle_status(PaymentMethod $payment): \Illuminate\Http\RedirectResponse
    {
        if ($payment->status)
        {
            $check_item = PaymentMethod::where('status', 1)->where('id', '!=', $payment->id)->first();
            if (!$check_item)
            {
                return back()->with(['error' => 'وجود یک روش فعال اجباری است']);
            }
            if ($payment->is_default)
            {
                return back()->with(['error' => 'نمیتوانید روش پیشفرض را غیرفعال کنید. لطفا ابتدا روش پیشفرض را تغییر دهید']);
            }
        }
        $payment->status = !$payment->status;
        $payment->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
    public function toggle_default(PaymentMethod $payment): \Illuminate\Http\RedirectResponse
    {
        if ($payment->is_default){
            return back()->with(['error' => 'انتخاب یک روش پیشفرض اجباری است']);
        }
        $payment->status = true;
        $payment->is_default = true;
        $payment->update();
        PaymentMethod::where('is_default', 1)->where('id', '!=', $payment->id)
            ->update(['is_default' => 0]);

        return back()->with(['message' => 'روش پیشفرض تغییر کرد']);
    }
}
