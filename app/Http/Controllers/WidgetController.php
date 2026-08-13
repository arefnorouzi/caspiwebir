<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Widget;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/widget/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/widget/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWidgetRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Widget::create($validated);
            Inertia::flash(['message' => config('messages.created')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.icon-box.index')->withErrors($e->getMessage());
        }

        return to_route('admin.widget.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Widget $widget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Widget $widget): \Inertia\Response
    {
        return Inertia::render('admin/widget/Edit', ['model' => $widget]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWidgetRequest $request, Widget $widget): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $widget->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.widget.index')->withErrors($e->getMessage());
        }

        return to_route('admin.widget.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Widget $widget): \Illuminate\Http\RedirectResponse
    {
        $widget->delete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }

    public function restore(Widget $widget): \Illuminate\Http\RedirectResponse
    {
        $widget->restore();
        Inertia::flash(['message' => config('messages.restored')]);

        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Widget $widget): \Illuminate\Http\RedirectResponse
    {
        $widget->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }
}
