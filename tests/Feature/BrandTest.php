<?php
use App\Models\Brand;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    $this->actingAs($this->admin, 'web');
    $this->withoutExceptionHandling(); // optional
});

test('brand-list', function () {

    Brand::factory()->count(5)->create();
    $response = $this->get(route('admin.brand.index'));
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('admin/brand/Index')
        ->has('models.data', 5)
    );
});


test('brand-create', function () {
    $data = Brand::factory()->make()->toArray();
    $response = $this->post(route('admin.brand.store'), $data);
    $response->assertRedirect(route('admin.brand.index'));
    $this->assertDatabaseHas('brands', ['name' => $data['name']]);
});

test('brand-update', function () {
    $model = Brand::factory()->create();
    $newData = ['name' => 'Updated Name', 'status' => true];
    $response = $this->patch(route('admin.brand.update', $model), $newData);
    $response->assertRedirect(route('admin.brand.index'));
    $this->assertDatabaseHas('brands', ['id' => $model->id, 'name' => 'Updated Name']);
});

test('brand-delete', function () {
    $model = Brand::factory()->create();
    $response = $this->delete(route('admin.brand.destroy', $model));
    $response->assertRedirect();
});

