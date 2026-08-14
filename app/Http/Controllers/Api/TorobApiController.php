<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TorobProductsResourceCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TorobApiController extends Controller
{
    public function index()
    {
        try {
            $results = Product::where('status', true)
                ->whereNotNull('published_at')
                ->paginate(100, ['id','name', 'price', 'offer_price', 'stock', 'image', 'thumbnail', 'guarantee']);

            return new TorobProductsResourceCollection($results);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response([
                'successful' => false,
                'error' => 'service unavailable'
            ], 500);
        }
    }
}
