<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Department;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/department/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/department/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Department::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.department.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }

        return to_route('admin.department.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): \Inertia\Response
    {
        return Inertia::render('admin/department/Edit', ['model' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $department->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.department.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.department.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): \Illuminate\Http\RedirectResponse
    {
        $department->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(Department $department): \Illuminate\Http\RedirectResponse
    {
        $department->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Department $department): \Illuminate\Http\RedirectResponse
    {
        $department->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }
}
