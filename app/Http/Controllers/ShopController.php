<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Product;
use App\Models\ProductRelated;
use App\Models\ProductRolePrice;
use App\Models\ProductVariant;
use App\Models\ShopSetting;
use App\Services\PregStr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{

    public function search(Request $request)
    {
        $q = $request->input('q');
        if(!$q || strlen(trim($q)) < 1) {
            return response()->json([]);
        }

        // نمونه: جستجو در فیلد title یا name
        $results = Product::query()
            ->where('status', true)
            ->whereNotNull('published_at')
            ->where(function($query) use ($q){
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('model', 'like', "%{$q}%")
                    ->orWhereHas('brand', function($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })
            ->orderByRaw("CASE WHEN name LIKE ? THEN 0 ELSE 1 END", ["{$q}%"]) // ترجیح نتایج که با q شروع میشه
            ->limit(10)
            ->get(['id','name','slug','price', 'offer_price', 'image', 'thumbnail']) // فیلدهایی که لازم داری
            ->map(function($p){
                return [
                    'id' => $p->id,
                    'title' => $p->name,
                    'image' => $p->thumbnail ?? $p->image,
                    'subtitle' => isset($p->price) ? 'قیمت: ' . number_format($p->offer_price ?? $p->price) . ' تومان' : null,
                    'url' => route('shop.show_product', $p->slug) ?? url("/p/{$p->id}")
                ];
            });

        return response()->json($results);
    }

    public function filter(Request $request)
    {
        try {
            $query = Product::query();
            $query->where('status', true)
                ->whereNotNull('published_at');
            // فیلتر دسته‌ها
            if ($request->categories) {
                $cat_ids = explode(',', $request->categories);
                if ($cat_ids)
                {
                    $categories = Category::whereIn('id',$cat_ids)
                        ->with('childrenRecursive:id,parent_id')
                        ->get(['id', 'parent_id']);
                    if ($categories)
                    {
                        $category_ids = [];
                        foreach ($categories as $category)
                        {
                            $category_ids[] = $category->id;
                            foreach ($category->children as $child) {
                                $category_ids[] = $child->id;
                                foreach ($child->children as $child2) {
                                    $category_ids[] = $child2->id;
                                    if ($child2->children)
                                    {
                                        foreach ($child2->children as $child3) {
                                            $category_ids[] = $child3->id;
                                        }
                                    }

                                }
                            }
                        }

                        $query->whereHas('categories', function ($q) use ($category_ids) {
                            $q->whereIn('categories.id', $category_ids);
                        });
                    }

                    //$query->whereIn('category_id', $allCatIds);

                }

            }

            // فیلتر برندها
            if ($request->brands) {
                $brands = explode(",", $request->brands);
                if ($brands)
                {
                    $query->whereIn('brand_id', $brands);
                }

            }

            // 🔥 فیلتر جستجو
            if ($request->search) {
                $query->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('model', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('sku', 'LIKE', '%' . $request->search . '%');
            }
            $query->orderBy('rank', 'asc');

            return response()->json([
                'products' => $query->paginate(30)
            ]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(status: 400);
        }
    }

    public function index(Request $request)
    {
        try {
            $product_model = new Product();
            $products = $product_model->recent_products($request->search ?? '');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $products = [];
        }

        try {
            $categories = Category::where('parent_id', null)
                ->where('id', '>=', 1)
                ->where('status', 1)
                ->with(['childrenRecursive:id,name,parent_id,slug'])
                ->get(['id', 'name', 'slug', 'parent_id']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }

        try {
            $brands = Brand::where('status', true)
                ->get(['id', 'name']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $brands = [];
        }
        $authorized = false;
        if (auth()->check())
        {
            $authorized = true;
        }
        $page = "shop";
        return view('shop.index', compact(
            'products', 'categories', 'brands', 'page', 'authorized'
        ));
    }
    public function off(Request $request)
    {
        try {
            $product_model = new Product();
            $products = $product_model->offer_products(perPage: 20);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $products = [];
        }

        try {
            $categories = Category::where('parent_id', null)
                ->where('id', '>=', 1)
                ->where('status', 1)
                ->with(['childrenRecursive:id,name,parent_id,slug'])
                ->get(['id', 'name', 'slug', 'parent_id']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        try {
            $brands = Brand::where('status', true)
                ->get(['id', 'name']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $brands = [];
        }
        $authorized = false;
        if (auth()->check())
        {
            $authorized = true;
        }
        $page = "off";
        return view('shop.index', compact('products',
            'categories', 'page', 'authorized', 'brands'
        ));

    }

    public function popular(Request $request)
    {
        try {
            $product_model = new Product();
            $products = $product_model->popular_products(per_page: 20);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $products = [];
        }

        try {
            $categories = Category::where('parent_id', null)
                ->where('id', '>=', 1)
                ->where('status', 1)
                ->with(['childrenRecursive:id,name,parent_id,slug'])
                ->get(['id', 'name', 'slug', 'parent_id']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        try {
            $brands = Brand::where('status', true)
                ->get(['id', 'name']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $brands = [];
        }
        $authorized = false;
        if (auth()->check())
        {
            $authorized = true;
        }
        $page = "popular";
        return view('shop.index', compact('products',
            'categories', 'page', 'authorized', 'brands'
        ));

    }

    public function featured(Request $request)
    {
        try {
            $product_model = new Product();
            $products = $product_model->featured_products(perPage: 20);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $products = [];
        }

        try {
            $categories = Category::where('parent_id', null)
                ->where('id', '>=', 1)
                ->where('status', 1)
                ->with(['childrenRecursive:id,name,parent_id,slug'])
                ->get(['id', 'name', 'slug', 'parent_id']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        try {
            $brands = Brand::where('status', true)
                ->get(['id', 'name']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $brands = [];
        }
        $authorized = false;
        if (auth()->check())
        {
            $authorized = true;
        }
        $page = "featured";
        return view('shop.index', compact('products',
            'categories', 'page', 'authorized', 'brands'
        ));

    }

    public function category($slug)
    {
        $slug = PregStr::preg_slug($slug);
        try {
            $category_ids = [];
            $category = Category::where('status', true)->where('slug', $slug)
                ->with(['children:id,name,parent_id,slug'])
                ->firstOrFail();
            $category_ids[] = $category->id;
            foreach ($category->children as $child) {
                $category_ids[] = $child->id;
                $child->load('children:id,parent_id');
                foreach ($child->children as $child2) {
                    $category_ids[] = $child2->id;
                }
            }
            $product_model = new Product();
            $products = $product_model->category_products($category_ids, $request->search ?? '');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect("/shop");
        }

        try {
            $categories = Category::where('id', $category->id)
                ->where('id', '>=', 1)
                ->where('status', 1)
                ->with(['childrenRecursive:id,name,parent_id,slug'])
                ->get(['id', 'name', 'slug', 'parent_id']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        try {
            $brands = Brand::where('status', true)
                ->get(['id', 'name']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $brands = [];
        }
        $authorized = false;
        if (auth()->check())
        {
            $authorized = true;
        }
        $page = "shop";
        $category_name = $category->name;
        return view('shop.caregory', compact('products',
            'categories', 'page', 'authorized', 'brands', 'category_name'
        ));
    }

    public function single_product($id)
    {
        $id = PregStr::preg_id($id);
        try {
            $product = Product::where('id', $id)->firstOrFail();
            return redirect("/shop/product/" . $product->slug);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect("/shop");
        }
    }

    public function show_product($slug)
    {
        $slug = PregStr::preg_slug($slug);
        try {
            $product_model = new Product();
            $product = $product_model->show_product_by_slug(slug: $slug);
            if ($product->views < 100000000)
            {
                $product->views += 1;
                $product->update();
            }
//            $product->with(['role_prices' => function ($q) {
//                if (auth()->check()) {
//                    $q->where('role_id', auth()->user()->role_id);
//                }
//            }]);
            $role_price_item = null;

            $product->load([
                'categories:id,name,slug',
                'brand:id,name,image,slug',
                'galleries', 'confirmed_comments',
                'properties'
            ]);
        }
        catch(\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('shop.index')
                ->with('error', 'محصول پیدا نشد. ممکن است فروش این محصول متوقف شده باشد.');
        }
        try {
            $related_ids = ProductRelated::where('product_id', $product->id)
                ->pluck('related_product_id')->toArray();
            $related_products = $product_model->related_items(ids: $related_ids);
            if (count($related_products) == 0)
            {
                $related_products = $product_model->related_products(
                    $product->id, categories: $product->categories->pluck('id')->toArray(),
                    brand_id: $product->brand_id
                );
            }

        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $related_products = [];
        }
        $shop_setting = ShopSetting::first();
        $product_schema = [
            "@context" => "https://schema.org/",
            "@type" => "Product",
            "name" => $product->name,
            "image" => [$product->image],
            "description" => $product->meta ?? $product->name,
            "sku" => $product->id,
            "brand" => [
                "@type" => "Brand",
                "name" => $product?->brand?->name ?? null
            ],
            "offers" => [
                "@type" => "Offer",
                "url" => url()->current(),
                "priceCurrency" => "IRR",
                "price" => $product->offer_price && $product->offer_price > 0 ? $product->offer_price : $product->price,
                "availability" => "https://schema.org/InStock",
                "itemCondition" => "https://schema.org/NewCondition"
            ]
        ];
        $pk = $product->id;
        $variants = ProductVariant::where('product_id', $product->id)
            ->where('stock', '>', 0)
            ->where('status', true)
            ->get();
        if ($product->downloadable)
        {
            $courses = Course::where('product_id', $product->id)
                ->where('status', true)
                ->with(['lessons'])->get();
            return view('shop.downloadable', compact(
                'product', 'related_products', 'shop_setting', 'pk',
                'role_price_item', 'product_schema', 'variants', 'courses'
            ));
        }

        return view('shop.show', compact(
            'product', 'related_products', 'shop_setting', 'pk',
            'role_price_item', 'product_schema', 'variants'
        ));
    }
}
