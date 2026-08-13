<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        try {
            $model = new Slider;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/slider/Index', [
            'models' => $models, 'search_text' => $request->search ?? '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/slider/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Slider::create($validated);
            Inertia::flash(['message' => config('messages.created')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);
            return to_route('admin.slider.index')->withErrors($e->getMessage());
        }

        return to_route('admin.slider.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider): \Inertia\Response
    {
        return Inertia::render('admin/slider/Edit', ['model' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $slider->update($validated);
            Inertia::flash(['message' => config('messages.updated')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);

            return to_route('admin.slider.index')->withErrors($e->getMessage());
        }

        return to_route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider): \Illuminate\Http\RedirectResponse
    {
        $slider->delete();
        Inertia::flash(['message' => config('messages.deleted')]);
        return back();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Slider $slider): \Illuminate\Http\RedirectResponse
    {
        $slider->restore();
        Inertia::flash(['message' => config('messages.restored')]);
        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Slider $slider): \Illuminate\Http\RedirectResponse
    {
        $slider->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);
        return back();
    }

    public function toggle_status(Slider $slider): \Illuminate\Http\RedirectResponse
    {
        $slider->status = !$slider->status;
        $slider->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
