<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Models\Favorite;
use App\Services\PregStr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserFavoriteController extends Controller
{
    public function index()
    {
        try {
            $models = Favorite::where('user_id', auth()->id())->orderBy('id', 'desc')
                ->with(['product:id,name,slug,image,price,offer_price,offer_end_date,stock'])
                ->paginate(10);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('dashboard/favorite/Index', ['models' => $models]);

    }

    public function store(StoreFavoriteRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            Favorite::create($validated);
            return response()->json(['message' => 'محصول به لیست علایق شما اضافه شد']);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطا در افزودن محصول به لیست علایق شما'], status: 400);
        }
    }

    public function destroy($id)
    {
        $id = PregStr::preg_id($id);
        try {
            $model = Favorite::where('id', $id)->where('user_id', auth()->id())->first();
            if (!$model) {
                return response()->json(['message' => 'آیتم پیدا نشد'], status: 404);
            }
            $model->delete();
            return response()->json(['message' => 'محصول از لیست علایق شما حذف شد']);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطا در حذف آیتم'], status: 400);
        }
    }
}
