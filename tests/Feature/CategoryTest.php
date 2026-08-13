<?php
use App\Models\Category;
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

test('category-list', function () {

    Category::factory()->count(5)->create();
    $response = $this->get(route('admin.category.index'));
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('admin/category/Index')
        ->has('models.data', 5)
    );
});


test('category-create', function () {
    $data = Category::factory()->make()->toArray();
    $response = $this->post(route('admin.category.store'), $data);
    $response->assertRedirect(route('admin.category.index'));
    $this->assertDatabaseHas('categories', ['name' => $data['name']]);
});

test('category-update', function () {
    $model = Category::factory()->create();
    $newData = ['name' => 'Updated Name', 'status' => true, 'home_page' => true];
    $response = $this->patch(route('admin.category.update', $model), $newData);
    $response->assertRedirect(route('admin.category.index'));
    $this->assertDatabaseHas('categories', ['id' => $model->id, 'name' => 'Updated Name']);
});

test('category-delete', function () {
    $model = Category::factory()->create();
    $response = $this->delete(route('admin.category.destroy', $model));
    $response->assertRedirect();
});

