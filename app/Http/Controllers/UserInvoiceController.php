<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewShopRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceLog;
use App\Models\InvoiceType;
use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\ShopSetting;
use App\Models\SmsNotification;
use App\Models\Wallet;
use App\Models\WalletSetting;
use App\Services\InvoiceService;
use App\Services\UserPlanService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
        $user = auth()->user();
        $wallet = Wallet::user_wallet(uid: $user->id);
        if ($user->role_id == 3)
        {
            $payment_methods = PaymentMethod::where('status', 1)
                ->where('code', '!=', 'wallet')
                ->orderby('is_default', 'desc')
                ->get();

        }
        else{
            $payment_methods = PaymentMethod::where('status', 1)
                ->where('code', '!=', 'bank-check')
                ->where('code', '!=', 'wallet')
                ->orderby('is_default', 'desc')
                ->get();

        }


        $shop_setting = ShopSetting::first();
        if ($invoice->invoice_type_id == 2)
        {
            return Inertia::render('dashboard/invoice/Withdraw', [
                'invoice' => $invoice, 'user' => $user, 'wallet' => $wallet,
                'payment_methods' => $payment_methods, 'shop_setting' => $shop_setting
            ]);
        }
        if ($invoice->invoice_type_id == 5)
        {
            $wallet_setting = WalletSetting::first();
            return Inertia::render('dashboard/invoice/Referral', [
                'invoice' => $invoice, 'user' => $user, 'wallet' => $wallet,
                'wallet_setting' => $wallet_setting, 'shop_setting' => $shop_setting
            ]);
        }
        if ($invoice->payment_status)
        {
            return Inertia::render('dashboard/invoice/Factor', [
                'invoice' => $invoice, 'user' => $user, 'wallet' => $wallet,
                'payment_methods' => $payment_methods, 'shop_setting' => $shop_setting
            ]);
        }
        $invoice = InvoiceService::refresh_invoice($invoice->id);
        if (!$invoice)
        {
            return redirect()->route('dashboard.invoice.index');
        }
        return Inertia::render('dashboard/invoice/Show', [
            'invoice' => $invoice, 'user' => $user, 'wallet' => $wallet,
            'payment_methods' => $payment_methods, 'shop_setting' => $shop_setting
        ]);
    }

    public function create()
    {
        abort(403);
    }

    public function store(NewShopRequest $request)
    {
        $request = $request->validated();
        DB::beginTransaction();
        try {
            $plan = Plan::where('status', 1)->where('id', $request['plan_id'])->firstOrFail();
            $sub_total = $plan->price;
            $tax = 0;
            $discount = 0;
            $plan_discount = 0;
            if ($plan->offer_price && $plan->price > $plan->offer_price) {
                $discount += $plan->price - $plan->offer_price;
                $plan_discount = $plan->price - $plan->offer_price;
            }

            $total = $sub_total + $tax - $discount + $plan->install_cost;

            $invoice_type = InvoiceType::find_item(code: 'buy');
            $invoice = Invoice::where('user_id', auth()->id())->where('payment_status', false)
                ->where('confirmed_by_user', false)->where('invoice_type_id', $invoice_type->id)->first();
            if (!$invoice)
            {
                $invoice = Invoice::create([
                    'uuid' => Str::uuid(),
                    'user_id' => auth()->id(),
                    'sub_total' => $sub_total,
                    'discount' => $discount,
                    'shipping_cost' => $plan->install_cost,
                    'tax' => $tax,
                    'amount' => $total,
                    'invoice_type_id' => $invoice_type->id,
                    'invoice_status_id' => 1,
                    'customer_name' => $request['customer_name'],
                    'customer_mobile' => $request['customer_phone'],
                ]);
            }
            else{
                $invoice->customer_name = $request['customer_name'];
                $invoice->customer_mobile = $request['customer_phone'];
                $invoice->sub_total += $sub_total;
                $invoice->tax += $tax;
                $invoice->discount += $discount;
                $invoice->shipping_cost += $plan->install_cost;
                $invoice->amount += $total;
                $invoice->update();
            }
            $invoice_item = InvoiceItem::where('invoice_id', $invoice->id)
                ->where('plan_id', $plan->id)->first();
            if ($invoice_item)
            {
                $invoice_item->qty += 1;
                $invoice_item->shipping_cost += $plan->install_cost;
                $invoice_item->update();
            }
            else{
                $invoice->items()->create([
                    'plan_type_id' => $plan->type->id,
                    'plan_id' => $plan->id,
                    'name' => $plan->name,
                    'unit_price' =>  $plan->offer_price ?? $plan->price,
                    'item_price' => $plan->price,
                    'discount' => $plan_discount,
                    'shipping_cost' => $plan->install_cost
                ]);
            }

            DB::commit();
            SmsNotification::create([
                'title' => 'فاکتور جدید',
                'to' => env('ADMIN_MOBILE'),
                'pattern_id' => 388161,
                'tokens' => json_encode([
                    '0' => "$invoice->id", '1' => "$invoice->amount",
                    '2' => "$invoice->user_id"
                ])
            ]);
            return response()->json(['message' => 'فاکتور با موفقیت ایجاد شد', 'invoice_id' => $invoice->id]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید'], 400);

        }
    }

    public function pay_with_balance(Invoice $invoice)
    {
        if ($invoice->user_id != auth()->id() || $invoice->invoice_type_id != 3 || $invoice->payment_status) {
            return response()->json(['message' => 'پیدا نشد'], 404);
        }
        $user = auth()->user();
        $wallet = Wallet::user_wallet(uid: $user->id);
        if ($wallet->balance >= $invoice->amount)
        {
            DB::beginTransaction();
            try {
                $payment_method_id = null;
                $payment_method = PaymentMethod::where('code', '=', 'wallet')->first();
                if ($payment_method)
                {
                    $payment_method_id = $payment_method->id;
                }
                $invoice->invoice_status_id = 2;
                $invoice->payment_status = true;
                $invoice->purchased_at = now();
                $invoice->paid_with_balance = true;
                $invoice->payment_method_id = $payment_method_id;
                $invoice->update();
                $balance = $wallet->balance;
                $wallet->balance = max(0, intval($wallet->balance - $invoice->amount));
                $wallet->buy = max(0, intval($wallet->buy + $invoice->amount));
                $wallet->update();
                InvoiceLog::create([
                    'invoice_id' => $invoice->id,
                    'user_id' => $invoice->user_id,
                    'title' => "پرداخت از کیف پول",
                    'log_data' => json_encode([
                        'before_balance' => $balance,
                        'after_balance' => $wallet->balance,
                        'amount' => $invoice->amount,
                        'sub_total' => $invoice->sub_total,
                        'shipping_cost' => $invoice->shipping_cost,
                        'tax' => $invoice->tax,
                        'discount' => $invoice->discount,
                    ]),
                    'log_time' => now(),
                ]);
                DB::commit();
                SmsNotification::create([
                    'title' => 'پرداخت فاکتور',
                    'to' => env('ADMIN_MOBILE'),
                    'pattern_id' => 388166,
                    'tokens' => json_encode([
                        '0' => "ادمین", '1' => "$invoice->id",
                        '2' => $invoice->status->name
                    ])
                ]);
                $user_name = $invoice->user ?? "کاربر";
                SmsNotification::create([
                    'title' => 'پرداخت فاکتور',
                    'to' => $invoice->user->mobile,
                    'pattern_id' => 388166,
                    'tokens' => json_encode([
                        '0' => $user_name, '1' => "$invoice->id",
                        '2' => $invoice->status->name
                    ])
                ]);
                UserPlanService::start_service(invoice_id: $invoice->id, uid: $invoice->user_id);

                return response()->json(['message' => 'فاکتور باموفقیت پرداخت شد']);

            }
            catch (\Exception $e)
            {
                Log::error($e->getMessage());
                DB::rollBack();
            }

        }
        return response()->json(['message' => 'موجودی کافی نیست'], 404);

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
