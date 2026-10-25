<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TorobApiProductsResource;
use App\Http\Resources\TorobApiProductsResourceCollection;
use App\Http\Resources\TorobProductsResourceCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TorobApiController extends Controller
{
    public function index()
    {
        try {
            $fields = [
                'id','name', 'price', 'offer_price', 'stock', 'image', 'thumbnail', 'guarantee',
                'brand_id', 'seo_meta', 'meta', 'created_at', 'updated_at'
            ];
            $products = Product::where('status', true)
                ->where('downloadable', 1)
                ->where('torob', 1)
                ->whereNotNull('published_at')
                ->paginate(100, $fields);

            return response()->json([
                "api_version" => "torob_api_v3",
                "total" => null,
                "max_pages" => null,
                "next_cursor" => null,
                "products" => new TorobApiProductsResourceCollection($products),
            ]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'invalid request'], 400);
        }
    }

    public function torob_products(Request $request): object
    {
        $product_ids = [];
        $fields = [
            'id','name', 'price', 'offer_price', 'stock', 'image', 'thumbnail', 'guarantee',
            'brand_id', 'seo_meta', 'meta', 'created_at', 'updated_at'
        ];
        $q = Product::query();
        $q->where('status', true)
            ->whereNotNull('published_at')
            ->where('torob', 1);
        $per_page = max(100, intval($request->per_page));
        if (isset($request->page_urls)) {
            foreach ($request->page_urls as $page_url) {
                $product_id = str_replace('https://caspiweb.ir/shop/p/', '', $page_url);
                $product_id = str_replace('http://caspiweb.ir/shop/p/', '', $page_url);
                $product_id = str_replace(url('/shop/p/'), '', $page_url);
                $product_id = intval(str_replace('/', '', $product_id));
                $product_ids[] = $product_id;
            }
            $q->whereIn('id', $product_ids);
            $products = $q->orderBy('id', 'desc')->get($fields);
            return response()->json([
                "api_version" => "torob_api_v3",
                "current_page" => 1,
                "total" => count($products),
                "max_pages" => 1,
                "products" => new TorobApiProductsResourceCollection($products),
            ]);
        }
        elseif (isset($request->page_uniques)) {
            foreach ($request->page_uniques as $page_id) {
                $product_ids[] = intval($page_id);
            }
            $q->whereIn('id', $product_ids);
            $q->whereIn('id', $product_ids);
            $products = $q->orderBy('id', 'desc')->get($fields);
            return response()->json([
                "api_version" => "torob_api_v3",
                "current_page" => 1,
                "total" => count($products),
                "max_pages" => 1,
                "products" => new TorobApiProductsResourceCollection($products),
            ]);
        }
        elseif (isset($request->page) && isset($request->sort)) {
            $page = max(1, intval($request->page));

            $q->when($request->sort == 'date_added_desc', function ($q) {
                return $q->orderBy('created_at', 'desc');
            });
            $q->when($request->sort == 'date_updated_desc', function ($q) {
                return $q->orderBy('updated_at', 'desc');
            });
            $products = $q->paginate($per_page, $fields, 'page', $page);

            return response()->json([
                "api_version" => "torob_api_v3",
                "current_page" => $page,
                "total" => $products->total(),
                "max_pages" => $products->lastPage(),
                "products" => new TorobApiProductsResourceCollection($products),
            ]);
        }
        elseif (isset($request->sort) && $request->sort == 'product_id_desc') {
            $next_cursor = null;
            if (isset($request->cursor))
            {
                $next_cursor = Product::where('status', true)
                    ->whereNotNull('published_at')
                    ->where('id', '<', intval($request->cursor))
                    ->where('torob', 1)->orderBy('id', 'desc')->first();
            }
            $q = Product::query();
            $q->where('status', true)
                ->whereNotNull('published_at')
                ->where('torob', 1)
                ->orderBy('id', 'desc');
            $products = $q->take(100)->get($fields);
            return response()->json([
                "api_version" => "torob_api_v3",
                "total" => null,
                "max_pages" => null,
                "next_cursor" => $next_cursor ? "$next_cursor->id" : "",
                "products" => new TorobApiProductsResourceCollection($products),
            ]);
        }
        return response()->json(['error' => 'invalid request'], 400);
    }

}
