<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $model = new Menu;
            $models = $model->all_items();
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        return Inertia::render('admin/menu/Index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $position = 'main_menu';
        if (isset($request->position) && $request->position != 'main_menu') {
            $position = $request->position;
        }
        $menus = Menu::where('position', '=', $position)->get(['id', 'name']);
        return Inertia::render('admin/menu/Create', [
            'position' => $position, 'menus' => $menus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        try {
            $validated = $request->validated();
            Menu::create($validated);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('admin.menu.index')
                ->with('error', config('messages.error'))
                ->withErrors($e->getMessage());
        }
        return to_route('admin.menu.index')
            ->with('message', config('messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $menus = Menu::where('position', '=', $menu->position)->get(['id', 'name']);
        return Inertia::render('admin/menu/Edit', ['model' => $menu, 'menus' => $menus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        try {
            $validated = $request->validated();
            $menu->update($validated);
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
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('message', config('messages.deleted'));
    }

    public function restore(Menu $menu): \Illuminate\Http\RedirectResponse
    {
        $menu->restore();
        return back()->with('message', config('messages.restored'));
    }

    public function toggle_status(Menu $menu): \Illuminate\Http\RedirectResponse
    {
        $menu->status = !$menu->status;
        $menu->update();
        return back()->with('message', 'وضعیت رکورد تغییر کرد');
    }
}
