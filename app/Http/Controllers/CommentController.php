<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Comment;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/comment/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
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
    public function store(StoreCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment): \Inertia\Response
    {
        return Inertia::render('admin/comment/Edit', ['model' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        try {
            $validated = $request->validated();
            $comment->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.comment.index')
                ->with(['error' => config('messages.error')])
                ->withErrors($e->getMessage());
        }
        return to_route('admin.comment.index')
            ->with(['message' => config('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        $comment->delete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function restore(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        $comment->restore();
        return back()->with(['message' => config('messages.restored')]);
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        $comment->forceDelete();
        return back()->with(['message' => config('messages.deleted')]);
    }

    public function toggle_status(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        $comment->status = !$comment->status;
        $comment->update();
        return back()->with(['message' => 'وضعیت رکورد تغییر کرد']);
    }
}
