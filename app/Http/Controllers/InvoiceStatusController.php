<?php

namespace App\Http\Controllers;

use App\Models\InvoiceStatus;
use App\Http\Requests\StoreInvoiceStatusRequest;
use App\Http\Requests\UpdateInvoiceStatusRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new InvoiceStatus();
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/InvoiceStatus/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/InvoiceStatus/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceStatusRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            InvoiceStatus::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.invoice-status.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.invoice-status.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceStatus $invoiceStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceStatus $invoiceStatus)
    {
        return Inertia::render('admin/InvoiceStatus/Edit', ['model' => $invoiceStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceStatusRequest $request, InvoiceStatus $invoiceStatus): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $invoiceStatus->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.invoice-status.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.invoice-status.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceStatus $invoiceStatus): \Illuminate\Http\RedirectResponse
    {
        $invoiceStatus->update(['status' => 0]);
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(InvoiceStatus $invoiceStatus): \Illuminate\Http\RedirectResponse
    {
        $invoiceStatus->update(['status' => 1]);
        return back()->with('message', config('messages.restored'));
    }
}
