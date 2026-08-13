<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateShopSettingRequest;
use App\Http\Requests\UpdateWebsiteSettingRequest;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ShopSetting;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $website_setting = WebsiteSetting::first();
        if (! $website_setting) {
            return redirect()->route('admin.website_setting');
        }
        $shop_setting = ShopSetting::first();
        if (! $shop_setting) {
            return redirect()->route('admin.shop_setting');
        }
        try {
            $model = new Invoice;
            $invoices = $model->purchased_items(search_text: $request->search ?? '');
            $month_sell = Invoice::where('created_at', '>=', now()->subDays(30))
                ->where('payment_status', true)->sum('amount');
            $month_invoces_count = Invoice::where('created_at', '>=', now()->subDays(30))->count();
            $purchased_invoces_count = Invoice::where('created_at', '>=', now()->subDays(30))
                ->where('payment_status', true)->count();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $invoices = [];
            $month_sell = 0;
            $month_invoces_count = 0;
            $purchased_invoces_count = 0;
        }
        try {
            $users_count = User::count();
            $open_tickets = Ticket::whereIn('status_id', [1, 3, 4])->count();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $users_count = 0;
            $open_tickets = 0;
        }
        $open_comments = Comment::where('status', 0)->count();

        $startDate = now()->subDays(29)->startOfDay();

        $invoices_records = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as total'),
            DB::raw('SUM(CASE WHEN payment_status = true THEN amount ELSE 0 END) as paid')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ساخت لیبل‌های ۳۰ روز کامل (حتی روزهای بدون دیتا)
        $dates = collect(range(0, 29))->map(function ($i) {
            return now()->subDays(29 - $i)->format('Y-m-d');
        });

        $chartData = [
            'labels' => [],
            'total' => [],
            'paid' => [],
        ];

        foreach ($dates as $date) {
            $day = $invoices_records->firstWhere('date', $date);

            $chartData['labels'][] = verta($date)->format('m/d');

            $chartData['total'][] = $day->total ?? 0;
            $chartData['paid'][] = $day->paid ?? 0;
        }
        $active_products_count = Product::active()->count();
        $out_of_stock_products_count = Product::active()->where('stock', 0)->count();

        $open_carts = Cart::where('status', 1)->count();

        return Inertia::render('admin/Index', [
            'website_setting' => $website_setting, 'shop_setting' => $shop_setting, 'open_carts' => $open_carts,
            'search_text' => $request->search ?? '', 'open_comments' => $open_comments,
            'invoices' => $invoices, 'users_count' => $users_count, 'open_tickets' => $open_tickets,
            'month_sell' => $month_sell, 'month_invoces_count' => $month_invoces_count,
            'purchased_invoces_count' => $purchased_invoces_count, 'invoices_chart' => $chartData,
            'out_of_stock_products_count' => $out_of_stock_products_count, 'active_products_count' => $active_products_count,
        ]);
    }

    public function pricing()
    {
        return Inertia::render('admin/Pricing');
    }

    public function system()
    {
        return Inertia::render('admin/setting/System');
    }

    public function setting()
    {
        return Inertia::render('admin/setting/Index');
    }

    public function website_setting()
    {
        $website_setting = WebsiteSetting::first();
        if (! $website_setting) {
            $website_setting = WebsiteSetting::create([
                'name' => 'فروشگاه من', 'phone' => '01344305892',
                'mobile' => '09192138510', 'whatsapp' => '989192138510',
                'address' => 'گیلان، رشت، میدان شهرداری', 'email' => 'info@caspiweb.ir',
                'instagram' => 'caspiweb_ir', 'telegram' => 'caspiweb_ir',
            ]);
        }

        return Inertia::render('admin/setting/Website', ['model' => $website_setting]);
    }

    public function shop_setting()
    {
        $model = ShopSetting::first();
        if (! $model) {
            $model = ShopSetting::create([
                'name' => 'فروشگاه من', 'phone' => '01344305892',
                'tax' => 0,
                'address' => 'گیلان، رشت، میدان شهرداری', 'email' => 'info@caspiweb.ir',
                'welcome_sms' => 'کاربر عزیز سلام. امیدوارم بهترینارو براتون در این سایت به ارمغان بیاریم.', 'telegram' => 'caspiweb_ir',
            ]);
        }

        return Inertia::render('admin/setting/Shop', ['model' => $model]);
    }

    public function update_website_setting(UpdateWebsiteSettingRequest $request)
    {
        $validated = $request->validated();
        $model = WebsiteSetting::firstOrFail();
        $model->update($validated);
        $model->refresh();
        // generate json file
        Artisan::call('cache:clear');

        return back()->with('success', 'تنظیمات با موفقیت بروزرسانی شد');

    }

    public function update_shop_setting(UpdateShopSettingRequest $request)
    {
        $validated = $request->validated();
        $model = ShopSetting::firstOrFail();
        $model->update($validated);
        $model->refresh();

        // generate json file
        return back()->with('success', 'تنظیمات با موفقیت بروزرسانی شد');
    }
}
