<?php

namespace App\Http\Controllers;

use App\Enums\PageSectionType;
use App\Http\Requests\StorePageSectionRequest;
use App\Http\Requests\UpdatePageSectionRequest;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PageSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new PageSection;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/PageSection/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): \Inertia\Response
    {
        $page_id = 1;
        if (isset($request->page_id)) {
            $page_id = $request->page_id;
        }
        $pages = Page::get(['id', 'name']);

        $page_sections = PageSection::where('page_id', $page_id)->get();

        return Inertia::render('admin/PageSection/Form', [
            'section' => null,
            'types' => collect(PageSectionType::cases())->map(fn ($t) => [
                'value' => $t->value,
                'label' => $t->label(),
            ]),
            'brands' => \App\Models\Brand::select('id', 'name')->get(),
            'categories' => \App\Models\Category::select('id', 'name')->get(),
            'pages' => $pages, 'page_id' => $page_id, 'page_sections' => $page_sections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageSectionRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            PageSection::create($validated);
            Inertia::flash(['message' => config('messages.created')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.page-section.index')->withErrors($e->getMessage());
        }

        return to_route('admin.page-section.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PageSection $pageSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageSection $pageSection): \Inertia\Response
    {
        $page_sections = PageSection::get();

        return Inertia::render('admin/page-section/Form', [
            'section' => $pageSection,
            'types' => collect(PageSectionType::cases())->map(fn ($t) => [
                'value' => $t->value,
                'label' => $t->label(),
            ]),
            'brands' => \App\Models\Brand::select('id', 'name')->get(),
            'categories' => \App\Models\Category::select('id', 'name')->get(),
            'page_sections' => $page_sections,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageSectionRequest $request, PageSection $pageSection): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $pageSection->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.page-section.index')->withErrors($e->getMessage());
        }

        return to_route('admin.page-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageSection $pageSection): \Illuminate\Http\RedirectResponse
    {
        $pageSection->delete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }

    public function restore(PageSection $pageSection): \Illuminate\Http\RedirectResponse
    {
        $pageSection->restore();
        Inertia::flash(['message' => config('messages.restored')]);

        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(PageSection $pageSection): \Illuminate\Http\RedirectResponse
    {
        $pageSection->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);

        return back();
    }
}
