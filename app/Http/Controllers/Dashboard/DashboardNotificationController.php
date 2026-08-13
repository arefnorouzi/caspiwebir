<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardNotificationController extends Controller
{
    public function index()
    {
        $models = Notification::where('status', 1)->where('dashboard', 1)
            ->where('user_id', null)
            ->orderBy('id', 'desc')
            ->paginate(10, ['id', 'pinned', 'name', 'meta', 'created_at']);
        $user_notifications = Notification::where('status', 1)->where('dashboard', 1)
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get(['id', 'pinned', 'name', 'meta']);
        return Inertia::render('dashboard/notification/Index', [
            'models' => $models,
            'user_notifications' => $user_notifications
        ]);
    }

    public function show(Notification $notification)
    {
        if (!$notification->status)
        {
            return redirect()->route('dashboard.notification.index');
        }
        return Inertia::render('dashboard/notification/Show', ['model' => $notification]);
    }
}
