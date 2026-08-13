<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Page;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/page/Index', [
            'models' => $models, 'search_text' => $request->search ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/page/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Page::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.page.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page): \Inertia\Response
    {
        return Inertia::render('admin/page/Edit', [
            'model' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        try {
            $validated = $request->validated();
            if ($page->status && is_null($page->published_at)) {
                $page->published_at = now();
            }
            $page->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.page.index')
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): \Illuminate\Http\RedirectResponse
    {
        $page->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(Page $page): \Illuminate\Http\RedirectResponse
    {
        $page->restore();
        return back()->with('message', config('messages.restored'));
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Page $page): \Illuminate\Http\RedirectResponse
    {
        $page->forceDelete();
        return back()->with('message', config('messages.deleted'));
    }

    public function toggle_status(Page $page)
    {
        if ($page->image && is_null($page->published_at))
        {
            $page->published_at = now();
        }
        $page->status = !$page->status;
        $page->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
