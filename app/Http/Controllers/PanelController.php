<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Province;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PanelController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        try {
            $invoice_model = new Invoice();
            $invoices = $invoice_model->user_items(uid: $user->id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $invoices = [];
        }

        try {
            $ticket_model = new Ticket();
            $tickets = $ticket_model->dashboard_tickets(uid: $user->id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $tickets = [];
        }

        try {
            $notifications = Notification::where('status', 1)->where('dashboard', 1)
                ->orderby('id', 'desc')
                ->get();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $notifications = [];
        }

        $admin_mobile = env('ADMIN_MOBILE');

        return Inertia::render('Dashboard', [
            'invoices' => $invoices, 'user' => $user, 'admin_mobile' => $admin_mobile,
            'tickets' => $tickets, 'notifications' => $notifications
        ]);
    }


    public function profile()
    {
        $user = User::where('id', auth()->id())->firstOrFail();
        $user->load(['province']);
        $provinces = Province::where('status', true)->get(['id', 'name']);
        return Inertia::render('dashboard/Profile', [
            'user' => $user, 'provinces' => $provinces
        ]);
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::where('id', auth()->id())->firstOrFail();

            $user->name = $validated['name'];
            $user->national_code = $validated['national_code'];
            $user->province_id = $validated['province_id'];
            $user->city = $validated['city'];
            $user->zip_code = $validated['zip_code'];
            $user->update();
            return back()->with('message', 'اطلاعات حساب کاربری شما با موفقیت بروزرسانی شد.');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطایی در بروزرسانی پروفایل رخ داد.');
        }
    }
}
