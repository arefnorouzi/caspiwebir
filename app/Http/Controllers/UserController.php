<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Invoice;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search');

        $users = User::query()
            ->when($search, fn ($q) =>
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
            )
            ->select('id', 'name', 'mobile')
            ->limit(20)
            ->get();

        return response()->json($users);
    }

    public function index(Request $request)
    {

        try {
            $model = new User();
            if (isset($request->trash))
            {
                $models = $model->trash_items(search_text: $request->search ?? '');
            }
            else {
                $models = $model->all_items(search_text: $request->search ?? '');
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/user/Index', [
            'models' => $models, 'search_text' => $request->search ?? ''
        ]);
    }

    public function create()
    {
        $provinces = Province::get(['id', 'name']);
        $roles = Role::where('id', '>', 2)->get(['id', 'name']);
        return Inertia::render('admin/user/Create', [
            'provinces' => $provinces, 'roles' => $roles
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        try {
            if (isset($validated['password']) && strlen($validated['password']) < 32) {
                $validated['password'] = Hash::make($validated['password']);
            }
            else{
                $pass = rand(12345678, 998877665);
                $validated['password'] = Hash::make("$pass");
            }
            User::create($validated);

            return back()
                ->with('message', 'رکورد با موفقیت ثبت شد.');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در ثبت کاربر');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['role']);
        $invoice_model = new Invoice();
        $invoices = $invoice_model->user_items(
            uid: $user->id
        );
        $provinces = Province::get(['id', 'name']);
        $roles = Role::where('id', '>', 2)->get(['id', 'name']);
        return Inertia::render('admin/user/Show', [
            'user' => $user, 'invoices' => $invoices, 'provinces' => $provinces, 'roles' => $roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        try {
            if (isset($validated['password']) && strlen($validated['password']) < 32) {
                $validated['password'] = Hash::make($validated['password']);
            }
            else{
                unset($validated['password']);
            }
            $user->update($validated);
            return back()->with('message', 'اطلاعات کاربر بروزرسانی شد');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'خطا در بروزرسانی اطلاعات کاربر');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
         $user->delete();
         return back()->with(['message' => config('messages.deleted')]);
    }

    public function restore(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->restore();
        return back()->with(['message' => config('messages.restored')]);
    }

    public function trash()
    {
        try {
            $model = new User();
            $models = $model->all_items(search_text: $request->search ?? '');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/user/Index', [
            'models' => $models, 'search_text' => $request->search ?? ''
        ]);
    }

    public function toggle_status(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->is_active = !$user->is_active;
        $user->update();
        return back()->with(['message' => 'وضعیت کاربر تغییر کرد']);
    }
}
