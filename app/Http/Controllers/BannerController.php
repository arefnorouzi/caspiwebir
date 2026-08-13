<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Models\PageSection;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        try {
            $model = new Banner;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/banner/Index', [
            'models' => $models, 'search_text' => $request->search ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        $page_sections = PageSection::where('status', true)->get(['id', 'name']);
        return Inertia::render('admin/banner/Create', ['page_sections' => $page_sections]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Banner::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.banner.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.banner.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner): \Inertia\Response
    {
        $page_sections = PageSection::where('status', true)->get(['id', 'name']);
        return Inertia::render('admin/banner/Edit', [
            'model' => $banner, 'page_sections' => $page_sections
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $banner->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.banner.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }

        return to_route('admin.banner.index')->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): \Illuminate\Http\RedirectResponse
    {
        $banner->delete();
        return back()->with('message', config('messages.deleted'));
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Banner $banner): \Illuminate\Http\RedirectResponse
    {
        $banner->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Banner $banner): \Illuminate\Http\RedirectResponse
    {
        $banner->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(Banner $banner): \Illuminate\Http\RedirectResponse
    {
        $banner->status = !$banner->status;
        $banner->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
