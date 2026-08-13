<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserServiceController extends Controller
{
    public function index()
    {
        $user_plan_model = new UserPlan();
        $user_plans = $user_plan_model->user_items(uid: auth()->id());
        return Inertia::render('dashboard/service/Index', ['user_plans' => $user_plans]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }


    public function show(UserPlan $userPlan)
    {
        if ($userPlan->user_id != auth()->id()) {
            return redirect('/dashboard');
        }
        $progress = $userPlan->progress;
        $userPlan->load(['user', 'plan', 'status']);
        $invoices = Invoice::where('user_id', auth()->id())->where('user_plan_id', $userPlan->id)
            ->with(['status', 'invoice_type'])
            ->orderby('id', 'desc')
            ->paginate(10);

        $plan_model = new Plan();
        $plans = $plan_model->dashboard_plans();

        $addon_model = new Addon();

        $pending_invoices = Invoice::where('user_id', auth()->id())
            ->where('user_plan_id', $userPlan->id)
            ->where('payment_status', 0)
            ->with(['status', 'invoice_type'])
            ->orderby('id', 'desc')
            ->get();

        return Inertia::render('dashboard/service/Show', [
            'user_plan' => $userPlan, 'invoices' => $invoices, 'plans' => $plans,
            'progress' => $progress, 'pending_invoices' => $pending_invoices
        ]);
    }

    public function edit(UserPlan $userPlan)
    {

    }

    public function update(Request $request, UserPlan $userPlan)
    {

    }

    public function destroy(UserPlan $userPlan)
    {

    }
}
