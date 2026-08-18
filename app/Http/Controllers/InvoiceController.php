<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryHelper;
use App\Http\Requests\AddInvoiceItemRequest;
use App\Http\Requests\UpdateInvoiceItemStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\InvoiceItem;
use App\Models\InvoiceItemStatus;
use App\Models\InvoiceStatus;
use App\Models\InvoiceStep;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\ShopSetting;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\InvoiceStepService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $model = new Invoice();
            if (isset($request->trash))
            {
                $models = $model->trash_items(search_text: $request->search ?? '');
            }
            else{
                $models = $model->all_items(search_text: $request->search ?? '');
            }

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/invoice/Index', [
            'models' => $models, 'search_text' => $request->search ?? ''
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
    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::findOrFail($validated['user_id']);
            $invoice = Invoice::create([
                'uuid' => Str::uuid(),
                'user_id' => $validated['user_id'],
                'payment_method_id' => $validated['payment_method_id'],
                'shipping_method_id' => $validated['shipping_method_id'],
                'invoice_status_id' => $validated['invoice_status_id'],
                'invoice_type_id' => $validated['invoice_type_id'],
                'customer_name' => $user->name,
                'customer_address' => $user->address,
                'customer_state' => $user?->province?->name ?? "",
                'customer_city' => $user->city,
                'customer_zip_code' => $user->zip_code,
                'customer_mobile' => $user->mobile,
                'customer_note' => $validated['customer_note'],
                'admin_created' => true
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'خطا در ثبت اطلاعات',
            ]);
        }
        return to_route('admin.invoice.edit', $invoice->id)
            ->with('success', 'رکورد با موفقیت ثبت شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        if (!$invoice->payment_status)
        {
            InvoiceService::refresh_invoice($invoice->id);
            $invoice->refresh();
        }
        $invoice->load(['status', 'invoice_type', 'user', 'items']);
        $shop_setting = ShopSetting::first();
        $statuses = InvoiceStatus::get(['id', 'name']);
        $payment_methods = PaymentMethod::get(['id', 'name']);
        $shipping_methods = ShippingMethod::get(['id', 'name']);
        $status_steps = InvoiceStatus::where('lifecycle', 1)->get(['id', 'name', 'lifecycle', 'image']);
        $invoice_steps = InvoiceStep::where('invoice_id', $invoice->id)
            ->pluck('invoice_status_id')
            ->toArray();

        return Inertia::render('admin/invoice/Show', [
            'invoice' => $invoice, 'shop_setting' => $shop_setting, 'statuses' => $statuses,
            'payment_methods' => $payment_methods, 'shipping_methods' => $shipping_methods,
            'invoice_steps' => $invoice_steps, 'status_steps' => $status_steps,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        if ($invoice->payment_status)
        {
            return back()->with('error', 'فاکتور پرداخت شده قابل ویرایش شدن نیست');
        }

        $invoice->load(['status', 'invoice_type', 'user', 'items']);

        $shop_setting = ShopSetting::first();
        $statuses = InvoiceStatus::get(['id', 'name']);
        $payment_methods = PaymentMethod::get(['id', 'name']);
        $shipping_methods = ShippingMethod::get(['id', 'name']);
        $category_model = new Category();
        $categories_list = $category_model->all_categories();
        $categories = CategoryHelper::buildCategoryTree($categories_list);
        $brands = Brand::get(['id', 'name']);
        $invoice_item_statuses = InvoiceItemStatus::get(['id', 'name']);
        return Inertia::render('admin/invoice/Edit', [
            'invoice' => $invoice, 'shop_setting' => $shop_setting, 'statuses' => $statuses,
            'payment_methods' => $payment_methods, 'shipping_methods' => $shipping_methods,
            'categories' => $categories, 'brands' => $brands,
            'invoice_item_statuses' => $invoice_item_statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $validated = $request->validated();
        try {
            $invoice_status = InvoiceStatus::findOrFail($validated['invoice_status_id']);
            if ($invoice_status->purchased)
            {
                $validated['payment_status'] = 1;
            }
            $invoice->update($validated);
            $invoice->refresh();
            InvoiceStepService::store_step($invoice, $invoice->invoice_status_id);
        }
        catch (\Exception $e)
        {
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
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }
    public function restore(Invoice $invoice): object
    {
        $invoice->restore();
        return back()->with(['message' => config('messages.restored')]);
    }


    public function factor(Invoice $invoice)
    {
        $invoice->load(['status', 'invoice_type', 'user', 'items', 'payment_method', 'shipping_method']);
        $shop_setting = ShopSetting::first();
        return Inertia::render('admin/invoice/Factor', [
            'invoice' => $invoice, 'shop_setting' => $shop_setting
        ]);
    }

    public function delete_item(InvoiceItem $invoice_item)
    {
        try {
            $invoice = Invoice::where('payment_status', false)->where('id', $invoice_item->invoice_id)->first();
            if (!$invoice)
            {
                return back()->withErrors([
                    'error' => 'خطا در ثبت اطلاعات',
                ]);
            }
            $invoice_id = $invoice_item->invoice_id;
            $invoice_item->delete();
            InvoiceService::refresh_invoice($invoice_id);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت اطلاعات');
        }
        return back()
            ->with('message', 'رکورد با موفقیت ثبت شد.');
    }

    public function increase_item_qty(InvoiceItem $invoice_item)
    {
        try {
            $invoice = Invoice::where('payment_status', false)->where('id', $invoice_item->invoice_id)->first();
            if (!$invoice)
            {
                return back()->withErrors([
                    'error' => 'خطا در ثبت اطلاعات',
                ]);
            }
            $invoice_id = $invoice_item->invoice_id;
            $invoice_item->qty += 1;
            $invoice_item->update();
            InvoiceService::refresh_invoice($invoice_id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت اطلاعات');
        }
        return back()
            ->with('message', 'رکورد با موفقیت ثبت شد.');


    }

    public function decrease_item_qty(InvoiceItem $invoice_item)
    {
        try {
            $invoice = Invoice::where('payment_status', false)->where('id', $invoice_item->invoice_id)->first();
            if (!$invoice)
            {
                return response()->json(['message' => 'آیتم پیدا نشد'], 404);
            }
            $invoice_id = $invoice_item->invoice_id;
            if ($invoice_item->qty > 1)
            {
                $invoice_item->qty -= 1;
                $invoice_item->update();
            }
            else{
                $invoice_item->delete();
            }
            InvoiceService::refresh_invoice($invoice_id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت اطلاعات');
        }
        return back()
            ->with('message', 'رکورد با موفقیت ثبت شد.');
    }

    public function add_item(AddInvoiceItemRequest $request, Invoice $invoice)
    {
        $validated = $request->validated();
        try {
            $validated['invoice_id'] = $invoice->id;
            $validated['discount'] = max(0, ($validated['item_price'] - $validated['unit_price']));
            InvoiceItem::create($validated);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت اطلاعات');
        }
        return back()
            ->with('success', 'رکورد با موفقیت ثبت شد.');
    }

    public function update_invoice_item_status(UpdateInvoiceItemStatus $request, InvoiceItem $item)
    {
        $validated = $request->validated();
        try {
            $item->update(['invoice_item_status_id' => $validated['invoice_item_status_id']]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطایی در پردازش درخواست رخ داد');
        }
        return back()->with('message', 'وضعیت آیتم باموفقیت بروزرسانی شد');
    }
}
