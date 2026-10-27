<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceLog;
use App\Models\PaymentMethod;
use App\Models\Province;
use App\Models\ShippingMethod;
use App\Models\ShopSetting;
use App\Models\User;
use App\Services\CartService;
use App\Services\InvoiceStepService;
use App\Services\PregStr;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart_model = new Cart();
        $cart = $cart_model->get_shopping_cart();
        $shipping_methods = ShippingMethod::where('status', true)->get();
        $provinces = Province::get();
        $user = null;
        if(auth()->check())
        {
            $user = auth()->user();
            $invoices = Invoice::where('user_id', $user->id)
                ->where('payment_status', false)
                ->where('created_at', '>', now()->subDays(10))
                ->get();
        }
        else
        {
            $invoices = Invoice::where('session_id', session()->getId())
                ->where('payment_status', false)
                ->where('created_at', '>', now()->subDays(10))
                ->get();
        }
        if (auth()->check() && auth()->user()->role_id <= 4)
        {
            $payment_methods = PaymentMethod::where('status', true)
                ->orderby('is_default', 'desc')
                ->get(['id', 'name', 'code', 'image', 'is_default', 'description', 'interest_rate']);
        }
        else{
            $payment_methods = PaymentMethod::where('status', true)
                ->where('code', '!=', 'bank-check')
                ->orderby('is_default', 'desc')
                ->get(['id', 'name', 'code', 'image', 'is_default', 'description', 'interest_rate']);
        }
        $default_payment_method = 1;
        foreach ($payment_methods as $payment_method)
        {
            if ($payment_method->is_default)
            {
                $default_payment_method = $payment_method->id;
                break;
            }
        }
        return view('checkout.index', compact(
            'cart',  'user', 'invoices', 'default_payment_method',
            'shipping_methods', 'provinces', 'payment_methods'
        ));
    }

    public function show($uuid)
    {
        $uuid = PregStr::preg_slug($uuid);
        try {
            $invoice = Invoice::where('uuid', $uuid)
                ->firstOrFail();
            $invoice->load(['items', 'shipping_method', 'payment_method']);
            $shop_setting = ShopSetting::first();
            if (auth()->check() && auth()->user()->role_id <= 4)
            {
                $payment_methods = PaymentMethod::where('status', true)
                    ->where('code', '!=', 'snapppay')
                    ->where('min_deposit', '<=', $invoice->amount)
                    ->where('max_deposit', '>=', $invoice->amount)
                    ->orderby('is_default', 'desc')
                    ->get(['id', 'name', 'code', 'image', 'is_default', 'description', 'interest_rate']);
            }
            else{
                $payment_methods = PaymentMethod::where('status', true)
                    ->where('code', '!=', 'bank-check')
                    ->where('code', '!=', 'snapppay')
                    ->where('min_deposit', '<=', $invoice->amount)
                    ->where('max_deposit', '>=', $invoice->amount)
                    ->orderby('is_default', 'desc')
                    ->get(['id', 'name', 'code', 'image', 'is_default', 'description', 'interest_rate']);
            }
            $snapp_gateway = PaymentMethod::where('status', true)
                ->where('code', '=', 'snapppay')
                ->where('min_deposit', '<=', $invoice->amount)
                ->where('max_deposit', '>=', $invoice->amount)->first();
            $shipping_methods = ShippingMethod::where('status', 1)->get(['id', 'name', 'base_cost']);
            if ($invoice->payment_status)
            {
                return view('checkout.factor', compact('invoice',
                    'shop_setting', 'shipping_methods', 'payment_methods'));
            }


            return view('checkout.show',
                compact('invoice', 'shop_setting',
                    'payment_methods', 'shipping_methods', 'snapp_gateway'));
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect('/checkout');
        }
    }

    public function store(CheckoutRequest $request)
    {
        $validated = $request->validated();
        $cart = CartService::refresh_cart();
        if (!$cart)
        {
            return response()->json(['message' => 'سبد خرید خالی است'], status: 400);
        }
        if ($cart->total_amount == 0 && $cart->sub_total == 0) {
            return response()->json(status: 403);
        }
        DB::beginTransaction();

        try {
            $province = Province::find($validated['province_id']);
            $pass = str(rand(12345678, 987654321));
            $user = User::where('mobile', $validated['mobile'])->first();
            if (!$user)
            {
                $user = User::create(
                    [
                        'mobile' => $validated['mobile'], 'address' => $validated['address'] ?? null,
                        'zip_code' => $validated['zip_code'] ?? null, 'city' => $validated['city'] ?? null,
                        'province_id' => $province->id, 'name' => $validated['name'],
                        'password' => bcrypt($pass), 'national_code' => $validated['national_code'] ?? null
                    ]
                );
//             ==
            }
            else{
                $user->update([
                    'province_id' => $province->id, 'name' => $validated['name'],
                    'address' => $validated['address'] ?? $user->address, 'zip_code' => $validated['zip_code'] ?? $user->zip_code,
                    'city' => $validated['city'] ?? $user->city, 'national_code' => $validated['national_code'] ?? $user->national_code
                ]);
            }

            $shop_setting = ShopSetting::first();
            $shipping = ShippingMethod::findOrFail($validated['shipping_method_id']);
            $payment_method = PaymentMethod::findOrFail($validated['payment_method_id']);
            $shipping_cost = $shipping->base_cost + $shipping->box_cost;
            $amount = max(0, intval($cart->sub_total - $cart->discount + $shipping_cost));
            $interest_amount = intval($amount * $payment_method->interest_rate);
            $invoice = Invoice::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'session_id' => session()->getId(),
                'sub_total' => intval($cart->sub_total),
                'discount' => intval($cart->discount),
                'shipping_cost' => $shipping_cost,
                'amount' => $amount,
                'interest_amount' => $interest_amount,
                'shipping_method_id' => $shipping->id,
                'payment_method_id' => $payment_method->id,
                'customer_name' => $request['name'],
                'customer_mobile' => $request['mobile'],
                'customer_address' => $request['address'],
                'customer_state' => $province->name,
                'customer_city' => $request['city'],
                'customer_zip_code' => $request['zip_code'],
                'customer_note' => $request['note'],
                'expired_at' => now()->addHours($shop_setting->order_expire)
            ]);

            foreach ($cart->items as $item) {
                $invoice->items()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'unit_price' => $item->unit_price,
                    'item_price' => $item->item_price,
                    'qty' => $item->qty,
                    'name'  => $item->name,
                ]);
            }
            InvoiceStepService::store_step($invoice, 1);
            // غیرفعال کردن سبد فعلی
            $cart->update(['status' => false, 'user_id' => $user->id]);
            InvoiceLog::create([
               'invoice_id' => $invoice->id,
               'user_id' => $user->id,
               'title' => 'صدور فاکتور',
               'log_data' => json_encode([
                   'amount' => $invoice->amount,
                   'discount' => $invoice->discount,
                   'sub_total' => $invoice->sub_total,
                   'tax' => $invoice->tax
               ]),
               'log_time' => now()
            ]);
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(status: 500);
        }

        try {
            SmsService::invoice_sms(
                to: $invoice->customer_mobile,
                invoice_number: $invoice->id,
                status: "درانتظار پرداخت"
            );
            SmsService::invoice_sms(
                to: $shop_setting->admin_mobile,
                invoice_number: $invoice->id,
                status: "درانتظار پرداخت"
            );

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return response()->json([
            'message' => 'صورتحساب با موفقیت ایجاد شد', 'uuid' => $invoice->uuid
        ], status: 201);
    }
}
