<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PaymentMethod;
use App\Models\ShopSetting;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserInvoiceController extends Controller
{
    public function index()
    {
        try {
            $invoice_model = new Invoice();
            $invoices = $invoice_model->user_items(uid: auth()->id());
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $invoices = [];
        }
        return Inertia::render('dashboard/invoice/Index', ['models' => $invoices]);
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id != auth()->id()) {
            return response()->json(['message' => 'پیدا نشد'], 404);
        }
        $invoice->load(['status', 'invoice_type', 'items', 'user']);
        if (count($invoice->items) == 0)
        {
            $invoice->delete();
            return redirect()->route('dashboard.invoice.index');
        }
        $banks = Bank::where('status', 1)->get(['id', 'name']);
        $check_method = null;

        $user = auth()->user();
        if ($user->role_id <= 3)
        {
            $payment_methods = PaymentMethod::where('status', 1)
                ->where('code', '!=', 'wallet')
                ->where('code', '!=', 'ctc')
                ->orderby('is_default', 'desc')
                ->get();

            $check_method = PaymentMethod::where('status', 1)
                ->where('code', '=', 'bank-check')->first();
        }
        else{
            $payment_methods = PaymentMethod::where('status', 1)
                ->where('code', '!=', 'bank-check')
                ->where('code', '!=', 'wallet')
                ->where('code', '!=', 'ctc')
                ->orderby('is_default', 'desc')
                ->get();

        }

        $ctc_method = PaymentMethod::where('code', 'ctc')->where('status', true)->first();


        $shop_setting = ShopSetting::first();
        if ($invoice->invoice_type_id == 2)
        {
            return Inertia::render('dashboard/invoice/Withdraw', [
                'invoice' => $invoice, 'user' => $user,
                'payment_methods' => $payment_methods, 'shop_setting' => $shop_setting
            ]);
        }
        if ($invoice->invoice_type_id == 5)
        {
            return Inertia::render('dashboard/invoice/Referral', [
                'invoice' => $invoice, 'user' => $user, 'shop_setting' => $shop_setting
            ]);
        }
        if (!$invoice->payment_status)
        {
            $invoice = InvoiceService::refresh_invoice($invoice->id);
            if (!$invoice)
            {
                return redirect()->route('dashboard.invoice.index');
            }
        }
        $documents = Document::where('invoice_id', $invoice->id)
            ->whereNotNull('document_path')
            ->get();

        $checks = null;
        $check_amount = 0;
        if ($invoice->check_count)
        {
            $checks = Document::where('invoice_id', $invoice->id)
                ->whereNotNull('check_date')
                ->whereNotNull('check_amount')
                ->where('need_upload', true)
                ->get();
            foreach ($checks as $check)
            {
                $check_amount = $check->check_amount;
                break;
            }
        }



        return Inertia::render('dashboard/invoice/Show', [
            'invoice' => $invoice, 'user' => $user, 'documents' => $documents,
            'payment_methods' => $payment_methods, 'shop_setting' => $shop_setting,
            'check_method' => $check_method, 'banks' => $banks, 'check_amount' => $check_amount,
            'checks' => $checks, 'ctc_method' => $ctc_method
        ]);
    }

    public function factor(Invoice $invoice)
    {
        if ($invoice->user_id != auth()->id()) {
            return redirect('/dashboard/invoice');
        }
        $invoice->load('user', 'status', 'invoice_type', 'items', 'payment_method', 'shipping_method');
        $shop_setting = ShopSetting::first();
        return Inertia::render('dashboard/invoice/Factor', [
            'invoice' => $invoice, 'shop_setting' => $shop_setting
        ]);
    }

    public function create()
    {
        abort(403);
    }

    public function store(Request $request)
    {

    }

    public function delete_item(InvoiceItem $invoice_item)
    {
        $invoice = Invoice::where('user_id', auth()->id())->where('payment_status', false)
            ->where('confirmed_by_user', false)->where('id', $invoice_item->invoice_id)->first();
        if (!$invoice)
        {
            return response()->json(['message' => 'آیتم پیدا نشد'], 404);
        }
        $invoice_id = $invoice_item->invoice_id;
        $invoice_item->delete();
        InvoiceService::refresh_invoice($invoice_id);
        return response()->json(['message' => 'آیتم از سفارش حذف شد.'], 204);

    }

    public function increase_item_qty(InvoiceItem $invoice_item)
    {
        $invoice = Invoice::where('user_id', auth()->id())->where('payment_status', false)
            ->where('confirmed_by_user', false)->where('id', $invoice_item->invoice_id)->first();
        if (!$invoice)
        {
            return response()->json(['message' => 'آیتم پیدا نشد'], 404);
        }
        $invoice_id = $invoice_item->invoice_id;
        $invoice_item->qty += 1;
        $invoice_item->update();
        InvoiceService::refresh_invoice($invoice_id);
        return response()->json(['message' => 'تعداد ایتم سفارش افزایش یافت.'], 204);

    }

    public function decrease_item_qty(InvoiceItem $invoice_item)
    {
        $invoice = Invoice::where('user_id', auth()->id())->where('payment_status', false)
            ->where('confirmed_by_user', false)->where('id', $invoice_item->invoice_id)->first();
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
            InvoiceService::refresh_invoice($invoice_id);
            return response()->json(['message' => 'آیتم از سفارش حذف شد.'], 204);

        }
        return response()->json(['message' => 'تعداد آیتم سفارش کم شد.'], 204);

    }
}
