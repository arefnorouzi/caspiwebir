<?php
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\User;

test('checkout', function () {
    $cart = Cart::factory()
        ->has(CartItem::factory()->count(3), 'items')
        ->create();
    $cart->load('user');
    $user = $cart->user;

    $shipping_method = \App\Models\ShippingMethod::factory()->create();
    $payment_method = \App\Models\PaymentMethod::factory()->create();
    $this->seed(\Database\Seeders\ShopSettingSeeder::class);
    $this->seed(\Database\Seeders\ProvinceSeeder::class);

    $response = $this->actingAs($user, 'web')
        ->post('/checkout', [
            'mobile' => '09192138510',
            'shipping_method_id' => $shipping_method->id,
            'payment_method_id' => $payment_method->id,
        ]);

    $response->assertStatus(201);
});
