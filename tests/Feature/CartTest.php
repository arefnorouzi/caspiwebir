<?php
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\ProductVariant;

beforeEach(function () {
    $this->withoutExceptionHandling(); // optional
});

test('cart-page', function () {
    $response = $this->get('/cart');

    $response->assertStatus(200);
});

test('guest-add-to-cart', function () {
    $normal_product = Product::factory()->published()->create();
    $offer_product = Product::factory()->offer()->published()->create();
    $variant = ProductVariant::factory()->create();
    $offer_variant = ProductVariant::factory()->offer()->create();

    $response = $this->post('/cart', ['product_id' => $normal_product->id]);
    $offer_response = $this->post('/cart', ['product_id' => $offer_product->id]);

    $variant_response = $this->post('/cart', [
        'product_id' => $variant->product_id, 'variant_id' => $variant->id
    ]);
    $offer_variant_response = $this->post('/cart', [
        'product_id' => $offer_variant->product_id, 'variant_id' => $offer_variant->id
    ]);

    $response->assertStatus(201);
    $offer_response->assertStatus(201);
    $variant_response->assertStatus(201);
    $offer_variant_response->assertStatus(201);
});

test('user-add-to-cart', function () {
    $normal_product = Product::factory()->published()->create();
    $offer_product = Product::factory()->offer()->published()->create();
    $variant = ProductVariant::factory()->create();
    $offer_variant = ProductVariant::factory()->offer()->create();

    $user = User::factory()->create();

    $response = $this->actingAs($user, 'web')
        ->post('/cart', ['product_id' => $normal_product->id]);

    $offer_response = $this->actingAs($user, 'web')
        ->post('/cart', ['product_id' => $offer_product->id]);

    $variant_response = $this->post('/cart', [
        'product_id' => $variant->product_id, 'variant_id' => $variant->id
    ]);
    $offer_variant_response = $this->post('/cart', [
        'product_id' => $offer_variant->product_id, 'variant_id' => $offer_variant->id
    ]);

    $response->assertStatus(201);
    $offer_response->assertStatus(201);
    $variant_response->assertStatus(201);
    $offer_variant_response->assertStatus(201);
});


test('increase-qty-cart-item', function () {
    $normal_product = Product::factory()->published()->create();
    $req = $this->post('/cart', ['product_id' => $normal_product->id]);
    $items = $req['items'];
    $cart_item = $items[0];
    $response = $this->patch("/cart/increase-qty", [
        'id' => $cart_item['id'], 'cart_id' => $cart_item['cart_id']
    ]);

    $response->assertStatus(200);
});


test('decrease-qty-cart-item', function () {
    $normal_product = Product::factory()->published()->create();
    $req = $this->post('/cart', ['product_id' => $normal_product->id]);
    $items = $req['items'];
    $cart_item = $items[0];
    $response = $this->patch("/cart/decrease-qty", [
        'id' => $cart_item['id'], 'cart_id' => $cart_item['cart_id']
    ]);

    $response->assertStatus(200);
});

test('remove-cart-item', function () {
    $normal_product = Product::factory()->published()->create();
    $req = $this->post('/cart', ['product_id' => $normal_product->id]);
    $cart_item = \App\Models\CartItem::first();
    $response = $this->post("/cart/remove", [
        'id' => $cart_item->id, 'cart_id' => $cart_item->cart_id
    ]);

    $response->assertStatus(200);
});
