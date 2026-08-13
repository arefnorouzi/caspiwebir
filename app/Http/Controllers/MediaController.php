<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Services\Files\MediaFolderName;
use App\Services\Files\MediaTypeService;
use App\Services\Files\ThumbnailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function list(Request $request): object
    {
        try {
            $model = new Media;
            $models = $model->media_list();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return response($models);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $model = new Media;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }

        return Inertia::render('admin/media/Index', [
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
    public function store(StoreMediaRequest $request)
    {
        try {
            $validated = $request->validated();
            $extension = strtolower($request->file->extension());
            $fileName = time() . '-' . rand(100, 9999999) . '.' . $extension;
            $fileType = MediaTypeService::get_media_type(extenstion: $extension);
            $folder = MediaFolderName::get_folder_name($fileType);
            $media_path = 'uploads/media/' . $folder;
            $validated['file']->move(public_path($media_path), $fileName);
            $thumbnail = null;
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $thumbnail = ThumbnailService::generate_thumbnail($media_path. $fileName, $extension);
            }
            Media::create([
                'name' => $fileName,
                'media_path' => '/' .$media_path .'/'. $fileName,
                'media_extension' => $extension,
                'thumbnail' => $thumbnail,
                'media_type' => $fileType
            ]);
            return back()->with(['message' => config('messages.created')]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with(['error' => 'خطا در بارگزاری فایل']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }

}
