<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        try {
            $validated = $request->validated();
            Lesson::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()->with(['message' => config('messages.created')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        try {
            $validated = $request->validated();
            $lesson->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => config('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson): \Illuminate\Http\RedirectResponse
    {
        $lesson->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function restore(Lesson $lesson): \Illuminate\Http\RedirectResponse
    {
        $lesson->restore();
        return back()->with(['message' => config('messages.restored')]);
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Lesson $lesson): \Illuminate\Http\RedirectResponse
    {
        $lesson->forceDelete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function toggle_status(Lesson $lesson): \Illuminate\Http\RedirectResponse
    {
        $lesson->status = !$lesson->status;
        $lesson->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
