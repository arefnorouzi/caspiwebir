<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryHelper;
use App\Http\Requests\GroupDiscountRequest;
use App\Http\Requests\ProductFastUpdateRequest;
use App\Http\Requests\ProductSizeRequest;
use App\Http\Requests\Seo\ProductSeoRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\InventoryProduct;
use App\Models\Product;
use App\Models\ProductProperty;
use App\Models\ProductRelated;
use App\Models\ProductRolePrice;
use App\Models\ProductUnit;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('perPage', 30);
        // محدود کردن به مقادیر مجاز برای امنیت
        $allowed = [10, 15, 20, 30, 50, 100];
        $perPage = in_array($perPage, $allowed) ? $perPage : 30;
        try {
            $model = new Product();
            if (isset($request->trash)){
                $models = $model->trash_items(search_text: $request->search ?? '', perPage: $perPage);
            }
            elseif(isset($request->outofstock)){
                $models = $model->outofstock_items(search_text: $request->search ?? '', perPage: $perPage);

            }
            else{
                $models = $model->all_items(request: $request, perPage: $perPage);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $models = [];
        }
        $category_model = new Category();
        $categories_list = $category_model->all_categories();
        $categories = CategoryHelper::buildCategoryTree($categories_list);
        $brands = Brand::get(['id', 'name']);
        return Inertia::render('admin/product/Index', [
            'models' => $models, 'categories' => $categories, 'brands' => $brands,
            'filters' => $request->only([
                'search',
                'status',
                'amazing',
                'suggested',
                'pinned',
                'buyable',
                'installment',
                'pre_order'
            ]),
            'today' => date('Y-m-d'),
            'perPage' => $perPage, // ارسال مقدار فعلی به Vue
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand_model = new Brand();
        $category_model = new Category();
        $product_unit_model = new ProductUnit();
        $categories = $category_model->select_categories();
        $brands = $brand_model->select_brands();
        $product_units = $product_unit_model->select_units();
        return Inertia::render('admin/product/Create', [
            'categories' => $categories, 'brands' => $brands, 'product_units' => $product_units
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $categories = $validated['categories'];
            unset($validated['categories']);
            if (isset($validated['image']) && strlen($validated['image']) > 0 && $validated['status']) {
                $validated['published_at'] = now();
            }
            $product = Product::create($validated);
            $product->categories()->attach($categories);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.product.index')
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return to_route('admin.product.index')
            ->with(['message' => config('messages.created')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): \Inertia\Response
    {
        return Inertia::render('admin/product/Show', ['model' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): \Inertia\Response
    {
        $product->withTrashed();
        $product->load(['categories', 'galleries', 'courses', 'variants']);
        $brand_model = new Brand;
        $category_model = new Category;
        $product_unit_model = new ProductUnit();
        $categories = $category_model->select_categories();
        $brands = $brand_model->select_brands();
        $selected_categories = $product->categories()->pluck('categories.id')->toArray();
        $properties = ProductProperty::where('product_id', $product->id)
            ->orderBy('id', 'desc')->orderByDesc('pinned')->get();
        $product_units = $product_unit_model->select_units();
        $roles = Role::where('id', '>', 1)->get(['id', 'name']);
        $product_role_prices = ProductRolePrice::where('product_id', $product->id)
            ->with(['role:id,name'])->get();
        $inventory_product = InventoryProduct::where('product_id', $product->id)
            ->with(['inventory:id,name'])
            ->get();
        $related_items = ProductRelated::where('product_id', $product->id)
            ->with(['product_related:id,name'])->get();
        return Inertia::render('admin/product/Edit', [
            'categories' => $categories, 'brands' => $brands, 'properties' => $properties,
            'model' => $product, 'selected_categories' => $selected_categories,
            'product_units' => $product_units, 'inventory_product' => $inventory_product,
            'roles' => $roles, 'product_role_prices' => $product_role_prices,
            'related_items' => $related_items
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $categories = $validated['categories'];
            unset($validated['categories']);
            if ($product->status && is_null($product->published_at)) {
                $product->published_at = now();
            }
            $product->update($validated);
            $product->categories()->sync($categories);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => config('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function restore(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->restore();
        return back()->with(['message' => config('messages.restored')]);
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->forceDelete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function product_publish(Product $product)
    {
        if ($product->image && is_null($product->published_at))
        {
            $product->published_at = now();
        }
        $product->status = !$product->status;
        $product->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }

    public function duplicate_product(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->load('categories', 'properties');
        try {
            $duplicated_product = Product::create([
                'name' => $product->name . " - " . time(),
                'image' => $product->image,
                'brand_id' => $product->brand_id,
                'sku' => $product->sku,
                'slug' => 'matbou-product-' . time(),
                'product_unit_id' => $product->product_unit_id,
                'user_id' => $product->user_id,
                'stock' => $product->stock,
            ]);
            $category_ids = [];
            foreach ($product->categories as $category) {
                $category_ids[] = $category->id;
            }
            $duplicated_product->categories()->attach($category_ids);
            foreach ($product->properties as $property) {
                ProductProperty::create([
                    'product_id' => $duplicated_product->id,
                    'property_name' => $property->property_name,
                    'property_value' => $property->property_value,
                    'pinned' => $property->pinned,
                ]);
            }
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.product.index')
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return to_route('admin.product.edit', $duplicated_product->id)
            ->with(['message' => 'محصول تکرار شد']);
    }

    public function product_seo(ProductSeoRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();
            $product->seo_title = $validated['seo_title'];
            $product->seo_meta = $validated['seo_meta'];
            $product->seo_keywords = $validated['seo_keywords'];
            $product->seo_tags = $validated['seo_tags'];
            $product->update();
            return back()->with('message', 'اطلاعات با موفقیت ذخیره شد');

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطایی در ثبت اطلاعات رخ داد');
        }

    }

    public function product_size(ProductSizeRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();
            $product->update($validated);
            return back()->with('message', 'اطلاعات با موفقیت ذخیره شد');

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطایی در ثبت اطلاعات رخ داد');
        }
    }

    public function fast_update(ProductFastUpdateRequest $request, Product $product): object
    {
        $validated = $request->validated();
        try {
            $product->update($validated);
            $product->refresh();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => 'خطا در ثبت اطلاعات',])
                ->withErrors($e->getMessage());
        }
        return back()->with('message', 'رکورد با موفقیت بروزرسانی شد.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);
        // در صورت استفاده از SoftDeletes
        Product::whereIn('id', $request->ids)->delete();
        return back()->with('message', 'محصولات انتخاب شده حذف شدند.');
    }

    public function bulkRestore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);
        // در صورت استفاده از SoftDeletes
        Product::whereIn('id', $request->ids)->restore();
        return back()->with('message', 'محصولات انتخاب شده حذف شدند.');
    }

    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)
            ->update(['status' => false]);

        return back()->with('message', 'محصولات انتخاب شده غیرفعال شدند.');
    }

    public function bulkActivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)
            ->update(['status' => true]);

        return back()->with('message', 'محصولات انتخاب شده فعال شدند.');
    }

    public function bulkSoldOut(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)
            ->update(['stock' => 0]);

        return back()->with('message', 'محصولات انتخاب شده ناموجود شدند.');
    }

    public function bulkInstock(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)
            ->update(['stock' => 1]);

        return back()->with('message', 'محصولات انتخاب شده موجود شدند.');
    }

    public function products_list(Request $request)
    {
        try {
            $model = new Product();
            if (isset($request->trash)){
                $models = $model->trash_items(search_text: $request->search ?? '', perPage: 100);
            }
            elseif(isset($request->outofstock)){
                $models = $model->outofstock_items(search_text: $request->search ?? '', perPage: 100);

            }
            else{
                $models = $model->all_items(request: $request, perPage: 100);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $models = [];
        }
        $category_model = new Category();
        $categories_list = $category_model->all_categories();
        $categories = CategoryHelper::buildCategoryTree($categories_list);
        $brands = Brand::get(['id', 'name']);
        return Inertia::render('admin/product/GroupDiscount', [
            'models' => $models, 'categories' => $categories, 'brands' => $brands,
            'filters' => $request->only([
                'search',
                'status',
                'amazing',
                'suggested',
                'pinned',
                'buyable',
                'torobpay',
                'pre_order',
                'categories',
                'brand'
            ]),
            'today' => date('Y-m-d')
        ]);
    }

    public function group_discount(GroupDiscountRequest $request)
    {
        try {
            $validated = $request->validated();
            if ($validated['discount_type'] == 'percent')
            {
                $discount_amount = 1 - round(floatval($validated['discount_value'] / 100), 2);
            }
            elseif ($validated['discount_type'] == 'fixed')
            {
                $discount_amount = intval($validated['discount_value']);
            }
            else{
                return back()
                    ->with(['error' => 'درخواست نامعتبر']);
            }
            // شروع تراکنش برای جلوگیری از ناهماهنگی
            DB::beginTransaction();
            $query = Product::query();

            $query->whereIn('id', $validated['ids']);

            // محاسبه offer_price جدید: price * (1 - percent/100)
            // همچنین می‌توان شرط داد که اگر قبلاً تخفیف داشت، بازنویسی شود
            $query->update([
                'offer_price' => $validated['discount_type'] == 'percent' ?
                    DB::raw("price * $discount_amount") : DB::raw("price - $discount_amount"),
                'offer_end_date' => isset($validated['offer_end_date']) ?? null
            ]);

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => 'تخفیف با موفقیت اعمال شد']);

    }

    public function remove_group_discount(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)
            ->update(['offer_price' => null, 'offer_end_date' => null]);

        return back()->with('message', 'تخفیف محصولات انتخاب شده حذف شد.');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $products_list = Product::query()
            ->where('status', true)
            ->when($search, fn ($q) =>
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
            )
            ->select('id', 'name', 'image', 'price', 'offer_price', 'offer_end_date', 'stock', 'sku')
            ->limit(20)
            ->get();
        $now = now(); // Laravel helper, uses app timezone



        $products = [];
        foreach ($products_list as $product) {
            $active_price = $product->price;
            if ($product->offer_price !== null && $product->offer_end_date instanceof \Carbon\Carbon && $now->lessThan($product->offer_end_date)) {
                $active_price = $product->offer_price;
            }
            $products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'offer_price' => $active_price,
                'stock' => $product->stock,
                'sku' => $product->sku,
            ];
        }
        return response()->json($products);
    }


}
