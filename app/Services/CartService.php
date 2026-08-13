<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartService
{

    public static function add_to_cart($data = []): array
    {
        DB::beginTransaction();
        try {
            // بررسی آیتم تکراری
            $cartItem = CartItem::where('cart_id', $data['cart_id'])
                ->where('product_id', $data['product_id'])
                ->where('product_variant_id', $data['product_variant_id'])
                ->first();

            if ($cartItem) {
                $cartItem->increment('qty', $data['qty']);
            } else {
                CartItem::create([
                    'cart_id' => $data['cart_id'],
                    'product_id' => $data['product_id'],
                    'product_variant_id' => $data['product_variant_id'],
                    'qty' => $data['qty'],
                    'name' => $data['name'],
                    'unit_price' => $data['unit_price'],
                    'item_price' => $data['product_price'],
                ]);
            }
            DB::commit();

            return [
                'status' => true,
                'message' => 'محصول با موفقیت به سبد خرید اضافه شد'
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Error adding to cart: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'افزودن به سبد خرید با خطا مواجه شد'
            ];
        }
    }

    public static function refresh_cart(){
        $cart_model = new Cart();
        $cart = $cart_model->get_shopping_cart();
        if (!$cart)
        {
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'status' => true,
                'session_id' => session()->getId()
            ]);
        }
        $sub_total = 0;
        $discount = 0;
        foreach ($cart->items as $item)
        {
            $sub_total += $item->item_price * $item->qty;
            $discount += max(0, $item->item_price - $item->unit_price) * $item->qty;
        }
        if ($cart->coupon_id)
        {

            $coupon = $cart->coupon;
            if ($coupon->isValidFor($cart)){
                $discount += $coupon->calculateDiscount($cart);
            }
        }
        $total_amount = max(0, $sub_total - $discount);
        $cart->discount = $discount;
        $cart->sub_total = $sub_total;
        $cart->total_amount = $total_amount;
        $cart->update();
        $cart->refresh();
        return $cart;
    }


}
