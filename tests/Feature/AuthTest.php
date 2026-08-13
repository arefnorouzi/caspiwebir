<?php
use App\Models\User;


test('simple login', function () {
    $user = User::factory()->create();

    $response = $this->post('/authentication/simple-login',[
        'mobile' => $user->mobile,
        'password' => 'password',
    ]);
    $response->assertStatus(200);
    $this->assertAuthenticated();

});

test('simple register', function () {
    $response = $this->post('/authentication/simple-register',[
        'mobile' => '09' . rand(123456789, 987654321),
        'password' => 'password',
    ]);
    $response->assertStatus(200);
    $this->assertAuthenticated();

});

test('invalid simple login', function () {
    $user = User::factory()->create();

    $this->post('/authentication/simple-login', [
        'mobile' => $user->mobile,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('invalid simple register', function () {
    $user = User::factory()->create();

    $this->post('/authentication/simple-register', [
        'mobile' => $user->mobile,
        'password' => 'password',
    ]);

    $this->assertGuest();
});
