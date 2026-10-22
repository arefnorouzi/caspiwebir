<?php

namespace App\Http\Controllers;

use App\Models\IconBox;
use App\Http\Requests\StoreIconBoxRequest;
use App\Http\Requests\UpdateIconBoxRequest;
use App\Models\PageSection;
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
        $page_sections = PageSection::where('status', true)->get(['id', 'name']);
        return Inertia::render('admin/icon-box/Create', ['page_sections' => $page_sections]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIconBoxRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            IconBox::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.box.index')->with('error', config('messages.error'));
        }

        return to_route('admin.box.index')->with('message', config('messages.created'));
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
    public function edit(IconBox $box): \Inertia\Response
    {
        $page_sections = PageSection::where('status', true)->get(['id', 'name']);
        return Inertia::render('admin/icon-box/Edit', [
            'model' => $box, 'page_sections' => $page_sections]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIconBoxRequest $request, IconBox $box): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $box->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.box.index')->withErrors($e->getMessage());
        }

        return to_route('admin.box.index')->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IconBox $box): \Illuminate\Http\RedirectResponse
    {
        $box->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(IconBox $box): \Illuminate\Http\RedirectResponse
    {
        $box->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(IconBox $box): \Illuminate\Http\RedirectResponse
    {
        $box->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(IconBox $box): \Illuminate\Http\RedirectResponse
    {
        $box->status = !$box->status;
        $box->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }
}
