<?php

namespace App\Http\Controllers;

use App\Models\IconBox;
use App\Http\Requests\StoreIconBoxRequest;
use App\Http\Requests\UpdateIconBoxRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class IconBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new IconBox;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/icon-box/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/icon-box/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIconBoxRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            IconBox::create($validated);
            Inertia::flash(['message' => config('messages.created')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.icon-box.index')->withErrors($e->getMessage());
        }

        return to_route('admin.icon-box.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(IconBox $iconBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IconBox $iconBox): \Inertia\Response
    {
        return Inertia::render('admin/icon-box/Edit', ['model' => $iconBox]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIconBoxRequest $request, IconBox $iconBox): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $iconBox->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.icon-box.index')->withErrors($e->getMessage());
        }

        return to_route('admin.icon-box.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IconBox $iconBox): \Illuminate\Http\RedirectResponse
    {
        $iconBox->delete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }

    public function restore(IconBox $iconBox): \Illuminate\Http\RedirectResponse
    {
        $iconBox->restore();
        Inertia::flash(['message' => config('messages.restored')]);

        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(IconBox $iconBox): \Illuminate\Http\RedirectResponse
    {
        $iconBox->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }
}
