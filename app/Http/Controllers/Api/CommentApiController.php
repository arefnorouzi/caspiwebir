<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\ProductCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentApiController extends Controller
{
    public function store_product_comment(ProductCommentRequest $request)
    {
        try {
            $validated = $request->validated();
            $product = Product::active()->where('id', $validated['product_id'])
                ->firstOrFail();
            $product->comments()->create([
                'user_id' => $validated['user_id'],
                'description' => $validated['description'],
            ]);
            return response()->json(['message' => 'نظر شما با موفقیت ثبت شد']);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در ثبت نظر رخ داد'], 400);
        }
    }

    public function store_post_comment(PostCommentRequest $request)
    {
        try {
            $validated = $request->validated();
            $post = Post::active()->where('id', $validated['post_id'])
                ->firstOrFail();
            $post->comments()->create([
                'user_id' => $validated['user_id'],
                'description' => $validated['description'],
            ]);
            return response()->json(['message' => 'نظر شما با موفقیت ثبت شد']);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در ثبت نظر رخ داد'], 400);
        }
    }
}
