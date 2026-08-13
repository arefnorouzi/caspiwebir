<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreCheckRequest;
use App\Http\Requests\Document\StoreReceiptRequest;
use App\Models\Bank;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserDocumentController extends Controller
{
    public function index()
    {

    }

    public function check_page()
    {
//        if (auth()->user()->role_id != 3)
//        {
//            return redirect('/dashboard/invoice')->with('error', 'دسترسی نامعتبر');
//        }
        // get last invoice
        try {
            $banks = Bank::where('status', 1)->get();
            $invoice = Invoice::where('payment_status', 0)
                ->where('user_id', auth()->id())
                ->with(['status', 'invoice_type'])
                ->firstOrFail();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect('/dashboard/invoice')->with('error', 'دسترسی نامعتبر');
        }
        Log::error($invoice);
        return Inertia::render("dashboard/document/Check", [
            'invoice' => $invoice, 'banks' => $banks
        ]);

    }

    public function receipt_page()
    {
        // get last invoice
    }

    public function store_check(StoreCheckRequest $request)
    {
        if (auth()->user()->role_id != 3)
        {
            return response()->json(['message' => 'دسترسی نامعتبر'], status: 403);
        }
        // two record must saved
        // check fron
        // chack back
        $validated = $request->validated();
        try {
            $invoice = Invoice::where('payment_status', 0)
                ->where('user_id', auth()->id())
                ->where('id', $validated['invoice_id'])
                ->with(['status', 'type'])
                ->firstOrFail();
            $doc_type = DocumentType::where('name', 'bank-check')->firstOrFail();
            Document::create([
                'user_id' => auth()->id(),
                'doc_type_id' => $doc_type->id,
                'shaba' => $validated['shaba'],
                'serial' => $validated['serial'],
                'seri' => $validated['seri'],
                'sayadi' => $validated['sayadi'],
                'note' => $validated['note'],
                'image1' => $validated['check_front'],
                'image2' => $validated['check_back'],
                'invoice_id' => $invoice->id,
            ]);
            $invoice->invoice_status_id = InvoiceStatus::get_status('finance_pending');
            $invoice->update();
            SmsService::send_with_pattern_raygan_sms([
                'to' => $invoice->user->mobile,
                'body_id' => "d67635a6-b281-4e65-ad00-43abf916cb5c",
                'message' => ["$invoice->id", "در انتظار تایید امور مالی"]
            ]);
            return response()->json(['message' => 'چک با موفقیت بارگزاری شد']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطا در بارگزاری چک'], status: 400);
        }
    }

    public function store_receipt(StoreReceiptRequest $request)
    {
        $validated = $request->validated();
        try {
            $invoice = Invoice::where('payment_status', 0)
                ->where('user_id', auth()->id())
                ->where('id', $validated['invoice_id'])
                ->with(['status', 'type'])
                ->firstOrFail();
            $doc_type = DocumentType::where('name', 'bank-check')->firstOrFail();
            Document::create([
                'user_id' => auth()->id(),
                'doc_type_id' => $doc_type->id,
                'note' => $validated['note'],
                'image1' => $validated['image'],
                'invoice_id' => $invoice->id,
            ]);
            $invoice->invoice_status_id = InvoiceStatus::get_status('finance_pending');
            $invoice->update();
            SmsService::send_with_pattern_raygan_sms([
                'to' => $invoice->user->mobile,
                'body_id' => "d67635a6-b281-4e65-ad00-43abf916cb5c",
                'message' => ["$invoice->id", "در انتظار تایید امور مالی"]
            ]);
            return response()->json(['message' => 'فیش واریزی با موفقیت بارگزاری شد']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطا در بارگزاری فیش واریزی'], status: 400);
        }
    }
}
