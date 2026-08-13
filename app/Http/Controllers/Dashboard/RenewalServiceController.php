<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\RenewalServiceRequest;
use App\Models\Addon;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\Plan;
use App\Models\ShopSetting;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RenewalServiceController extends Controller
{
    public function index()
    {
        // list of services that need renewal
    }

    public function store(RenewalServiceRequest $request)
    {
        $request = $request->validated();
        DB::beginTransaction();
        try {
            $user_plan = UserPlan::where('id', $request['user_plan_id'])->where('user_id', auth()->id())
                ->firstOrFail();
            $plan = null;
            if (isset($request['plan_id']))
            {
                $plan = Plan::where('status', 1)->where('id', $request['plan_id'])->firstOrFail();
            }
            $addons = [];
            if (isset($request['addons']))
            {
                $addons = Addon::where('status', 1)->whereIn('id', $request['addons'])->get();
            }
            $discount = 0;
            $plan_discount = 0;
            $sub_total = 0;
            if ($plan)
            {
                $sub_total = $plan->offer_price ?? $plan->price;
                if ($plan->offer_price && $plan->price > $plan->offer_price) {
                    $discount += $plan->price - $plan->offer_price;
                    $plan_discount = $plan->price - $plan->offer_price;
                }
            }
            foreach ($addons as $addon) {
                $sub_total += $addon->offer_price ?? $addon->price;
                if ($addon->offer_price && $addon->price > $addon->offer_price) {
                    $discount += $addon->price - $addon->offer_price;
                }
            }
            if ($sub_total == 0)
            {
                return response()->json(['message' => 'باید حداقل یک سرویس یا افزودنی انتخاب شود.'], 400);

            }
            $shop_setting = ShopSetting::firstOrFail();

            $tax = intval($sub_total * $shop_setting->tax / 100);

            $total = $sub_total + $tax - $discount;

            $invoice_type = InvoiceType::find_item(code: 'buy');

            $invoice = Invoice::create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'user_plan_id' => $user_plan->id,
                'sub_total' => $sub_total,
                'discount' => $discount,
                'tax' => $tax,
                'amount' => $total,
                'invoice_type_id' => $invoice_type->id,
                'customer_name' => auth()->user()->name,
                'customer_mobile' => auth()->user()->mobile,
                'expired_at' => now()->addDays($shop_setting->order_expire),
            ]);
            if ($plan)
            {
                $invoice->items()->create([
                    'plan_id' => $plan->id,
                    'name' => $plan->name,
                    'unit_price' =>  $plan->offer_price ?? $plan->price,
                    'item_price' => $plan->price,
                    'discount' => $plan_discount
                ]);
            }

            foreach ($addons as $addon) {
                $item_discount = 0;
                if ($addon->offer_price && $addon->price > $addon->offer_price) {
                    $item_discount += $addon->price - $addon->offer_price;
                }
                $invoice->items()->create([
                    'addon_id' => $addon->id,
                    'name' => $addon->name,
                    'unit_price' =>  $addon->offer_price ?? $addon->price,
                    'item_price' => $addon->price,
                    'discount' => $item_discount
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'فاکتور با موفقیت ایجاد شد', 'invoice_id' => $invoice->id]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید'], 400);

        }
    }
}
