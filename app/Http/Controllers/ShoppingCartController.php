<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\DecreaseCartItemQtyRequest;
use App\Http\Requests\IncreaseCartItemQtyRequest;
use App\Http\Requests\RemoveCartItemRequest;
use App\Http\Requests\UpdateCartItemQtyRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductRolePrice;
use App\Models\ProductVariant;
use App\Models\ShippingMethod;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{

    public function index()
    {
        $cart_model = new Cart();
        CartService::refresh_cart();
        $cart = $cart_model->get_shopping_cart();
        return view('cart.index', compact('cart'));
    }
    public function summary()
    {
        $cart_model = new Cart();
        $cart = $cart_model->get_shopping_cart();

        if (!$cart) {
            return response()->json([
                'count' => 0,
                'sub_total' => 0,
                'total_amount' => 0,
                'items' => []
            ]);
        }

        return response()->json([
            'count' => $cart->items->sum('qty'),
            'sub_total' => $cart->sub_total,
            'total_amount' => $cart->total_amount,
            'items' => $cart->items->map(fn($item) => [
                'id' => $item->id,
                'name' => $item->product->name,
                'image' => $item->product->image ?? $item->variant?->image,
                'price' => $item->unit_price,
                'total' => $item->total,
                'qty' => $item->qty,
                'slug' => $item->product->slug,
            ])
        ]);
    }

    public function remove_item(RemoveCartItemRequest $request)
    {
        $validated = $request->validated();
        $cart_item = CartItem::where('id', $validated['id'])
            ->where('cart_id', $validated['cart_id'])
            ->whereHas('cart', function ($q) {
                $q->where('status', true);
            })
            ->first();
        if (!$cart_item) {
            return response()->json(['message' => 'رکورد موردنظر پیدا نشد.'], 404);
        }
        $cart_item->delete();
        return response()->json(['message' => 'آیتم از سبد خرید حذف شد']);
    }

    public function update_qty(UpdateCartItemQtyRequest $request)
    {
        $request = $request->validated();
        try {
            $cart_model = new Cart();
            $cart = $cart_model->get_shopping_cart();
            if(!$cart)
            {
                return response()->json(['message' => 'رکورد موردنظر پیدا نشد.'], 404);
            }
            $cart_item = CartItem::where('id', $request['item_id'])
                ->where('cart_id', $cart->id)->first();
            if (!$cart_item) {
                return response()->json(['message' => 'رکورد موردنظر پیدا نشد.'], 404);
            }
            if ($request['status'])
            {
                if($cart_item->product_variant_id)
                {
                    $variant = ProductVariant::where('id', $cart_item->product_variant_id)
                        ->where('stock', '>', $cart_item->qty)->first();
                    if (!$variant)
                    {
                        return response()->json(['message' => 'تعداد درخواستی بیشتر از موجودی انبار است.'], 404);
                    }
                }
                else{
                    $product = Product::active()->where('id', $cart_item->product_id)
                        ->first();
                    if (!$product)
                    {
                        return response()->json(['message' => 'تعداد درخواستی بیشتر از موجودی انبار است.'], 404);
                    }
                }
                $cart_item->qty += 1;
                $cart_item->update();
            }
            else{
                if ($cart_item->qty > 1 ){
                    $cart_item->qty -= 1;
                    $cart_item->update();
                }
                else{
                    $cart_item->delete();
                }
            }
            CartService::refresh_cart();
            $cart = $cart_model->get_shopping_cart();
            return response()->json(['cart' => $cart]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در بروزرسانی رخ داد'], 400);
        }
    }

    public function increase_qty(IncreaseCartItemQtyRequest $request)
    {
        try {
            $validated = $request->validated();
            $cart_item = CartItem::where('id', $validated['id'])
                ->where('cart_id', $validated['cart_id'])
                ->whereHas('cart', function ($q) {
                    $q->where('status', true);
                })
                ->first();
            if (!$cart_item) {
                return response()->json(['message' => 'رکورد موردنظر پیدا نشد.'], 404);
            }
            if($cart_item->product_variant_id)
            {
                $variant = ProductVariant::where('id', $cart_item->product_variant_id)
                    ->where('stock', '>', $cart_item->qty)->first();
                if (!$variant)
                {
                    return response()->json(['message' => 'تعداد درخواستی بیشتر از موجودی انبار است.'], 404);
                }
            }
            else{
                $product = Product::active()->where('id', $cart_item->product_id)
                    ->first();
                if (!$product)
                {
                    return response()->json(['message' => 'تعداد درخواستی بیشتر از موجودی انبار است.'], 404);
                }
            }
            $cart_item->qty += 1;
            $cart_item->update();
            CartService::refresh_cart();
            $cart_model = new Cart;
            $cart = $cart_model->get_shopping_cart();
            return response()->json(['cart' => $cart]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در بروزرسانی رخ داد'], 400);
        }
    }

    public function decrease_qty(DecreaseCartItemQtyRequest $request)
    {
        try {
            $validated = $request->validated();
            $cart_model = new Cart();
            $cart_item = CartItem::where('id', $validated['id'])
                ->where('cart_id', $validated['cart_id'])
                ->whereHas('cart', function ($q) {
                    $q->where('status', true);
                })
                ->first();
            if (!$cart_item) {
                return response()->json(['message' => 'رکورد موردنظر پیدا نشد.'], 404);
            }
            if ($cart_item->qty > 1){
                $cart_item->qty -= 1;
                $cart_item->update();
            }
            else{
                $cart_item->delete();
            }
            CartService::refresh_cart();
            $cart = $cart_model->get_shopping_cart();
            return response()->json(['cart' => $cart]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در بروزرسانی رخ داد'], 400);
        }
    }

    public function add_to_cart(AddToCartRequest $request)
    {
        $validated = $request->validated();
        try {
            $product_model = new Product();

            $product = $product_model->find_for_add_to_cart($validated['product_id']);
            if (!$product)
            {
                return response()->json(['message' => 'فروش این محصول متوقف شده است'], 400);
            }
            $unit_price = $product->active_price;
            $product_price = $product->price;
            if (auth()->check())
            {
                $role_price = ProductRolePrice::where('product_id', $product->id)
                    ->where('role_id', auth()->user()->role_id)->first();
                if ($role_price)
                {
                    $unit_price = $role_price->offer_price ?? $role_price->price;
                    $product_price = $role_price->price;
                }
            }
            $variant = null;
            if (isset($validated['product_variant_id']))
            {
                $variant = ProductVariant::where('status', true)
                    ->where('product_id', $product->id)
                    ->where('id', $validated['product_variant_id'])->first();
                if (!$variant)
                {
                    return response()->json(['message' => 'درحال حاضر امکان افزودن این محصول با مشخصات انتخاب شده به سبد خرید وجود ندارد.'], 400);
                }
                $unit_price = $variant->active_price;
                $product_price = $variant->price;
            }


            $cart_model = new Cart();
            $cart = $cart_model->get_shopping_cart();
            if (!$cart)
            {
                $cart = Cart::create([
                   'user_id' => auth()->id(),
                   'session_id' => session()->getId(),
                   'sub_total' => 0,
                   'discount' => 0
                ]);
            }
            $product_name = $product->name;
            if ($variant)
            {
                $product_name = $product->name . " ($variant->name)";
            }
            $data = [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant ? $variant->id : null,
                'unit_price' => $unit_price,
                'qty' => $validated['qty'],
                'name' => $product_name,
                'product_price' => $product_price
            ];
            $req = CartService::add_to_cart( data: $data);
            if (!$req["status"])
            {
                return response()->json(['message' => $req['message']], 400);
            }

            $cart->load('items');
            $sub_total = 0;
            $discount = 0;
            foreach ($cart->items as $item)
            {
                $sub_total = $item->unit_price * $item->qty;
            }
            if ($cart->coupon_id)
            {
                $coupon = $cart->coupon;
                if ($coupon->isValid){
                    $discount = $coupon->applyDiscount($sub_total);
                }
            }
            $total_amount = max(0, $sub_total - $discount);
            $cart->discount = $discount;
            $cart->sub_total = $sub_total;
            $cart->total_amount = $total_amount;
            $cart->update();
            $cart->refresh();
            return response()->json([
                'message' => $req['message'], 'cart' => $cart, 'items' => $cart->items
            ], 201);

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return response()->json(['message' => 'خطایی در افزودن محصول به سبد خرید رخ داد. لطفا دوباره تلاش کنید.'], 400);
    }

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $cart = Cart::with('items')
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('user_id', $userId)
                    ->orWhere('session_id', $sessionId);
            })
            ->where('status', true)
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'سبد خرید شما خالی است.'], 400);
        }
        if ($cart->coupon_id || $cart->coupon_code)
        {
            return response()->json(['message' => 'شما از تخفیف دیگری استفاده کرده اید'], 400);

        }

        $coupon = Coupon::where('code', $validated['code'])->where('active', true)->first();

        if (!$coupon) {
            return response()->json(['message' => 'کد تخفیف معتبر نیست'], 400);
        }
        if (!$coupon->isValidFor($cart)) {
            return response()->json(['error' => 'این کوپن در حال حاضر معتبر نیست.'], 422);
        }

        $discount = $coupon->calculateDiscount($cart);

        $cart->update([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'discount' => $cart->discount + $discount,
            'total_amount' => $cart->sub_total - $discount,
        ]);
        $coupon->increment('used_count');

        CartService::refresh_cart();
        $cart_model = new Cart();
        $cart = $cart_model->get_shopping_cart();

        return response()->json([
            'message' => 'کد تخفیف با موفقیت اعمال شد.',
            'cart' => $cart
        ]);
    }

    public function removeCoupon(Request $request)
    {
        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $cart = Cart::with('items')
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('user_id', $userId)
                    ->orWhere('session_id', $sessionId);
            })
            ->where('status', true)
            ->first();

        if (! $cart || ! $cart->coupon_id) {
            return response()->json(['message' => 'هیچ کوپنی برای حذف وجود ندارد.'], 400);
        }
        $coupon = Coupon::find($cart->coupon_id);

        $subtotal = $cart->items->sum(fn($item) => $item->unit_price * $item->qty);

        DB::transaction(function () use ($cart, $subtotal, $coupon) {
            $cart->update([
                'coupon_id' => null,
                'coupon_code' => null,
                'discount' => 0,
                'sub_total' => $subtotal,
                'total_amount' => $subtotal,
            ]);
            if ($coupon && $coupon->used_count > 0)
            {
                $coupon->decrement('used_count');
            }
        });

        CartService::refresh_cart();
        $cart_model = new Cart();
        $cart = $cart_model->get_shopping_cart();

        return response()->json([
            'message' => 'کد تخفیف با موفقیت اعمال شد.',
            'cart' => $cart
        ]);
    }

}
