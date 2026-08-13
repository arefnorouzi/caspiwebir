<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Course();
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/course/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (isset($request->product_id))
        {
            $product = Product::find($request->product_id);
        }
        else{
            return redirect('admin.course.index');
        }
        return Inertia::render('admin/course/Create', [
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $validated = $request->validated();
            Course::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return back()
            ->with(['message' => config('messages.created')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('admin/course/Edit', ['model' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            $validated = $request->validated();
            $course->update($validated);
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
    public function destroy(Course $course): \Illuminate\Http\RedirectResponse
    {
        $course->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function restore(Course $course): \Illuminate\Http\RedirectResponse
    {
        $course->restore();
        return back()->with(['message' => config('messages.restored')]);
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Course $course): \Illuminate\Http\RedirectResponse
    {
        $course->forceDelete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function toggle_status(Course $course): \Illuminate\Http\RedirectResponse
    {
        $course->status = !$course->status;
        $course->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
