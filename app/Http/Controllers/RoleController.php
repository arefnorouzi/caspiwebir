<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        try {
            $model = new Role;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/role/Index', [
            'models' => $models, 'search_text' => $request->search ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/role/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Role::create($validated);
            Inertia::flash(['message' => config('messages.created')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);
            return to_route('admin.role.index')->withErrors($e->getMessage());
        }
        return to_route('admin.role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): \Inertia\Response
    {
        return Inertia::render('admin/role/Edit', ['model' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $role->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);
            return to_route('admin.role.index')->withErrors($e->getMessage());
        }
        return to_route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): \Illuminate\Http\RedirectResponse
    {
        $role->delete();
        Inertia::flash(['message' => config('messages.deleted')]);
        return back();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Role $role): \Illuminate\Http\RedirectResponse
    {
        $role->restore();
        Inertia::flash(['message' => config('messages.restored')]);
        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Role $role): \Illuminate\Http\RedirectResponse
    {
        $role->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);
        return back();
    }
}
