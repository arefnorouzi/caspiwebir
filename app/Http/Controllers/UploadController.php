<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use App\Models\Product;
use App\Services\Files\MediaTypeService;
use App\Services\Files\ThumbnailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,svg|max:2048'
            ]);

            $folder_name = 'uploads/images';
            if (isset($request->folder_name)){
                $folder_name = 'images/' . $request->folder_name;
            }
            $extension = strtolower($request->file->extension());
            $fileName = time() . '.' . $extension;

            $request->file->move(public_path($folder_name), $fileName);
            $thumbnail = null;
            if (isset($request->product_id))
            {
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $thumbnail = ThumbnailService::generate_thumbnail($folder_name . '/' . $fileName, $extension);
                }
                Product::where('id', $request->product_id)->update(['image' => '/' . $folder_name . '/' . $fileName]);
            }
            if (isset($request->post_id))
            {
                Post::where('id', $request->post_id)->update(['image' => '/' . $folder_name . '/' . $fileName]);
            }


            Media::create([
                'name' => $fileName,
                'media_path' => '/' . $folder_name . '/' . $fileName,
                'media_extension' => $extension,
                'thumbnail' => $thumbnail,
                'media_type' => MediaTypeService::get_media_type(extenstion: $extension)
            ]);

            return response()->json([
                'url' => '/' . $folder_name . '/' . $fileName,
                'path' => '/' . $folder_name . '/' . $fileName,
                'thumbnail' => $thumbnail
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => 'خطا در بارگزاری تصویر'], status: 400);
        }

    }


    public function editorImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);
        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('images/uploads'), $fileName);
        //$path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'location' => '/images/uploads/'. $fileName
        ]);
    }

    public function upload_document(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,txt,docx,xlsx,doc,xls|max:5000',
        ]);
        $fileName = time() . '-' . rand(100, 9999999) . '.' . $request->file->extension();

        $request->file->move(public_path('uploads/documents/'), $fileName);

        return response()->json([
            'location' => '/uploads/documents/'. $fileName
        ]);
    }
}
