<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\SocialNetwork;
use App\Http\Requests\StoreSocialNetworkRequest;
use App\Http\Requests\UpdateSocialNetworkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SocialNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new SocialNetwork();
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/social/Index', [
            'models' => $models, 'search_text' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/social/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialNetworkRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            SocialNetwork::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.social.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.social.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialNetwork $socialNetwork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialNetwork $social): \Inertia\Response
    {
        return Inertia::render('admin/social/Edit', ['model' => $social]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialNetworkRequest $request, SocialNetwork $social): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $social->update($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return back()
            ->with('message', config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialNetwork $social): \Illuminate\Http\RedirectResponse
    {
        $social->delete();
        return back()->with('message', config('messages.deleted'));
    }


    public function toggle_status(SocialNetwork $social): \Illuminate\Http\RedirectResponse
    {
        $social->status = !$social->status;
        $social->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }

}
