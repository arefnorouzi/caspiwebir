<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $startDate = now()->subDays(29)->startOfDay();

        $invoices = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN payment_status = true THEN 1 ELSE 0 END) as paid")
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $users = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
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
        $userChart = [
            'labels' => [],
            'total' => [],
        ];


        foreach ($dates as $date) {
            $day = $invoices->firstWhere('date', $date);
            $user_day = $users->firstWhere('date', $date);

            $chartData['labels'][] = verta($date)->format('m/d');

            $chartData['total'][] = $day->total ?? 0;
            $chartData['paid'][]  = $day->paid ?? 0;

            $userChart['total'][]  = $user_day->total ?? 0;
            $userChart['labels'][] = verta($date)->format('m/d');
        }

        return Inertia::render('admin/chart/Index', [
            'invoices_chart' => $chartData,
            'users_chart' => $userChart
        ]);
    }
}
